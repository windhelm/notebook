<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Repositories\UserSocialsRepository;
use App\Repositories\UserRepository;

class AuthController extends Controller
{

    /**
     * The category note repository instance.
     */
    protected $usersSocialsRepo;
    /**
     * The users repository instance.
     */
    protected $usersRepo;

    public function __construct(UserRepository $users, UserSocialsRepository $userSocialsRepository)
    {
        $this->usersSocialsRepo = $userSocialsRepository;
        $this->usersRepo = $users;
    }

    public function redirectToProvider()
    {
        return \Socialite::driver('vkontakte')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = \Socialite::driver('vkontakte')->user();


    }

}
