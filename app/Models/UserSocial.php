<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    //
    protected $table = "user_socials";

    protected $fillable = [
        'provider', 'provider_user_id', 'token'
    ];
}
