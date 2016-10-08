<?php

namespace App\Http\Controllers\Account;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Repositories\UserRepository;
use App\Repositories\CategoryNoteRepository;

class CategoryNoteController extends Controller
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
     * Create a new controller instance.
     *
     * @param  UserRepository  $users
     * @param  CategoryNoteRepository $categories
     *
     */
    public function __construct(CategoryNoteRepository $categories,UserRepository $users)
    {
        $this->categoriesRepo = $categories;
        $this->usersRepo = $users;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = \Auth::user();
        $categories = $this->categoriesRepo->getCategoriesByUser($user)->paginate(5);

        return view('categories/index',['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('categories/create');
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
            'title' => 'required|min:4|max:40|note_unique',
            'description' => 'max:200'
        ]);

        $category = $this->categoriesRepo->create([
            'title' => $request->input('title'),
            'description' => $request->input('description')
        ]);

        $this->usersRepo->setCategory($user, $category);

        return redirect()->route('categories.index')->with('status', 'Категория успешно добавлена!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoriesRepo->find($id);

        if (!\Gate::allows('category', $category)) {
            abort(403, 'Unauthorized action.');
        }

        return view('categories/show',['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->categoriesRepo->find($id);

        if (!\Gate::allows('category', $category)) {
            abort(403, 'Unauthorized action.');
        }

        return view('categories/edit',['category' => $category]);
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
            'title' => 'required|min:4|max:40',
            'description' => 'max:200'
        ]);

        $category = $this->categoriesRepo->find($id);

        if (!\Gate::allows('category', $category)) {
            abort(403, 'Unauthorized action.');
        }

        $this->categoriesRepo->update($category,[
            "title" => $request->input('title'),
            "description" => $request->input('description')
        ]);

        return redirect()->route('categories.index')->with('status', 'Категория успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categoriesRepo->find($id);

        if (!\Gate::allows('category', $category)) {
            abort(403, 'Unauthorized action.');
        }

        $this->categoriesRepo->delete($category);

        if(\Request::ajax()){
            return $id;
        }

        return redirect()->route('categories.index')->with('status', 'Категория успешно удалена!');
    }
}
