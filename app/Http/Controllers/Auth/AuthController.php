<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\UserSocial;
use App\Repositories\UserRepository;
use App\Repositories\UserSocialRepository;

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

    public function __construct(UserRepository $users,UserSocialRepository $userSocial)
    {
        $this->usersSocialsRepo = $userSocial;
        $this->usersRepo = $users;
    }

    public function redirectToProvider()
    {
        $user = \Auth::user();

        if ($user->check_social()){
            return redirect()->back()->with('status', 'Аккаунт уже прикреплен!');
        }

        return \Socialite::driver('vkontakte')->scopes(['notes'])->redirect();
    }

    public function handleProviderCallback()
    {
        $userProvider = \Socialite::driver('vkontakte')->user();

        $user = \Auth::user();

        // create new social account
        $userSocial = $this->usersSocialsRepo->create([
            'provider_user_id' => $userProvider->getId(),
            'provider' => 'vkontakte',
            'token' => $userProvider->token
        ]);

        $this->usersRepo->setSocial($user,$userSocial);

        return redirect('/home')->with('status', 'Ваш аккаунт успешно привязан!');

    }

    public function socialRemove()
    {
        $user = \Auth::user();
        $provider = "vkontakte";

        if (!$user->check_social()){
            return redirect('/home')->with('status', 'Аккаунт соц сети не найден!');
        }

        $this->usersRepo->removeSocial($user,$provider);
        return redirect('/home')->with('status', 'Ваш аккаунт успешно откреплен!');
    }


}
