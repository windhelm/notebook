<?php
namespace App\Repositories;

use App\Models\UserSocial;

class UserSocialRepository
{

    public function find($id)
    {
        return UserSocial::find($id);
    }

    public function create(array $data)
    {
        $userSocial = new UserSocial($data);
        return $userSocial;
    }

    public function delete($id)
    {
        return UserSocial::where('id',$id)->delete();
    }
}