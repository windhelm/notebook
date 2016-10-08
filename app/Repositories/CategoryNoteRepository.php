<?php
namespace App\Repositories;

use App\Models\CategoryNote as CategoryNote;

class CategoryNoteRepository
{

    public function getAll()
    {
        return CategoryNote::all();
    }

    public function find($id)
    {
        return CategoryNote::findOrFail($id);
    }

    public function delete($category)
    {
        return $category->delete();
    }

    public function getCategoriesByUser($user)
    {
        return $user->categories_notes();
    }

    public function create(array $data)
    {
        $category = new CategoryNote($data);
        return $category;
    }

    public function update($category, array $data)
    {
        $category->update($data);
    }
}