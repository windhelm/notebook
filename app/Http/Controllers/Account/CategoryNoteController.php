<?php

namespace App\Http\Controllers\Account;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\CategoryNote;

use App\Repositories\CategoryNoteRepository;

class CategoryNoteController extends Controller
{

    /**
     * The category note repository instance.
     */
    protected $categories;

    protected $users;

    /**
     * Create a new controller instance.
     *
     * @param  CategoryNoteRepository  $users
     * @return void
     */
    public function __construct(CategoryNoteRepository $categories,UserRepository $users)
    {
        $this->categories = $categories;
        $this->users = $users;
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
        $categories = $this->users->getAllCategoriesByUser($user->id)->paginate(5);

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
            'title' => 'min:4|max:40',
            'description' => 'max:200'
        ]);

        $category = new CategoryNote([
            'title' => $request->input('title'),
            'description' => $request->input('description')
        ]);

        $user->categories_notes()->save($category);

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
        $category = $this->categories->find($id);

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
        $category = $this->categories->find($id);

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
            'title' => 'min:4|max:40',
            'description' => 'max:200'
        ]);

        $category = CategoryNote::findOrFail($id);

        if (!\Gate::allows('category', $category)) {
            abort(403, 'Unauthorized action.');
        }

        $category->title = $request->input('title');
        $category->description = $request->input('description');
        $category->save();

        $user = \Auth::user();
        return redirect()->route('categories.index',["categories" => $user->categories_notes])->with('status', 'Категория успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = CategoryNote::findOrFail($id);

        if (!\Gate::allows('category', $category)) {
            abort(403, 'Unauthorized action.');
        }

        $category->delete();

        if(\Request::ajax()){
            return $id;
        }

        $user = \Auth::user();

        return redirect()->route('categories.index',["categories" => $user->categories_notes])->with('status', 'Категория успешно удалена!');
    }
}
