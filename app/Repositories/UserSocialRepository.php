<?php
namespace App\Repositories;

use App\Models\UserSocial;
use App\User;

class UserSocialsRepository
{

    public function find($id)
    {
        return UserSocial::find($id);
    }



    public function delete($id)
    {
        return UserSocial::where('id',$id)->delete();
    }
}