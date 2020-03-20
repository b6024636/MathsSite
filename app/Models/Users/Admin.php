<?php

namespace App\Models\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden =[
        'password',
        'remember_token'
    ];
}
