<?php
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

    public function setNote($user, $note)
    {
        $user->notes()->save($note);
    }

    public function setSocial($user, $social)
    {
        $user->social()->save($social);
    }

    public function delete($id)
    {
        return User::where('id',$id)->delete();
    }

    public function checkSocial($user)
    {
        return $user->check_social();
    }

    public function removeSocial($user,$provider)
    {
        $user->social()->where('provider',$provider)->first()->delete();
    }

}