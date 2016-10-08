<?

namespace App\Repositories;

use App\User;

class UserRepository
{

    public function find($id)
    {
        return User::find($id);
    }

    public function setCategory($user, $category)
    {
        $user->categories_notes()->save($category);
    }

    public function delete($id)
    {
        return User::where('id',$id)->delete();
    }
}