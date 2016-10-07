<?

namespace App\Repositories;

use App\User;

class UserRepository
{

    public function getAllCategoriesByUser($id)
    {
        return User::findOrFail($id)->categories_notes();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function delete($id)
    {
        return User::where('id',$id)->delete();
    }
}