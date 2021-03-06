<?php

namespace App\Http\Controllers\Account;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Repositories\NoteRepository;
use App\Repositories\UserRepository;
use App\Repositories\CategoryNoteRepository;

class NoteController extends Controller
{
    /**
     * The category note repository instance.
     */
    protected $categoriesRepo;
    /**
     * The users repository instance.
     */
    protected $usersRepo;
    /**
     * The users repository instance.
     */
    protected $notesRepo;
    /**
     * Create a new controller instance.
     *
     * @param  UserRepository  $users
     * @param  CategoryNoteRepository $categories
     *
     */

    protected $client;

    public function __construct(CategoryNoteRepository $categories,UserRepository $users, NoteRepository $notes)
    {
        $this->categoriesRepo = $categories;
        $this->usersRepo = $users;
        $this->client = new Client();
        $this->notesRepo = $notes;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function send($access_token,$method)
    {
        $url = 'https://api.vk.com/method/'.$method;
        $params = array(
            'access_token' => $access_token,  // access_token можно вбить хардкодом, если работа будет идти из под одного юзера
            'v' => '5.37',
        );

        // В $result вернется id отправленного сообщения
        $result = file_get_contents($url, false, stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($params)
            )
        )));

        return $result;
    }

    public function index()
    {
        $user = \Auth::user();

        // if user have social vk account try get notes vk

        if($this->usersRepo->checkSocial($user)){

            $access_token = $user->social()->where('provider','vkontakte')->first()->token;
            $response = $this->send($access_token,'notes.get');
            $notes_vk = $response;
        }else{
            $notes_vk = '{"response":"noacc"}';
        }

        $categories = $this->categoriesRepo->getCategoriesByUser($user)->get();
        $notes_uncategory = $this->notesRepo->getUncotegoryNotesByUser($user)->get();

        return view('notes/index',['categories' => $categories,'notes_uncategory' => $notes_uncategory,'notes_vk' => json_decode($notes_vk)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();

        $categories = $this->categoriesRepo->getCategoriesByUser($user)->get();

        return view('notes/create',["categories" => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = $request->user();

        $this->validate($request, [
            'title' => 'required|min:4|max:100',
            'text' => 'required|max:1024'
        ]);

        $note = $this->notesRepo->create([
            'title' => $request->input('title'),
            'text' => $request->input('text'),
            'category_id' => $request->input('category')
        ]);

        //assign to user
        $this->usersRepo->setNote($user, $note);

        return redirect()->route('notes.index')->with('status', 'Заметка успешно добавлена!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = $this->notesRepo->find($id);

        if (!\Gate::allows('note', $note)) {
            abort(403, 'Unauthorized action.');
        }

        return view('notes/show',['note' => $note]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = \Auth::user();
        $note = $this->notesRepo->find($id);

        if (!\Gate::allows('note', $note)) {
            abort(403, 'Unauthorized action.');
        }
        $categories = $this->categoriesRepo->getCategoriesByUser($user)->get();

        return view('notes/edit',['note' => $note,'categories'=> $categories]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:4|max:100',
            'text' => 'required|max:1024'
        ]);

        $note = $this->notesRepo->find($id);

        if (!\Gate::allows('note', $note)) {
            abort(403, 'Unauthorized action.');
        }

        $this->notesRepo->update($note,[
            "title" => $request->input('title'),
            "text" => $request->input('text'),
            "category_id" => $request->input('category')
        ]);

        return redirect()->route('notes.index')->with('status', 'Заметка успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = $this->notesRepo->find($id);

        if (!\Gate::allows('note', $note)) {
            abort(403, 'Unauthorized action.');
        }

        $this->notesRepo->delete($note);

        if(\Request::ajax()){
            return $id;
        }

        return redirect()->route('notes.index')->with('status', 'Заметка успешно удалена!');
    }
}
