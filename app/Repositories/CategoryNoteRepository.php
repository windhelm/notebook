<?

namespace App\Repositories;

use App\Models\CategoryNote as CategoryNote;

class CategoryNoteRepository
{

    public function getAll()
    {
        return CategoryNote::getAll();
    }

    public function find($id)
    {
        return CategoryNote::findOrFail($id);
    }

    public function delete($id)
    {
        return CategoryNote::where('id',$id)->delete();
    }
}