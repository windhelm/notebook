<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function categories_notes()
    {
        return $this->hasMany('App\Models\CategoryNote');
    }

    public function notes()
    {
        return $this->hasMany('App\Models\Note');
    }

    public function get_uncategories_notes()
    {
        return $this->notes()->where('category_id','NULL');
    }

    public function social()
    {
        return $this->hasMany('App\Models\UserSocial');
    }

    public function check_social()
    {
        if (count($this->social) > 0)
            return true;
        else
            return false;
    }
}
