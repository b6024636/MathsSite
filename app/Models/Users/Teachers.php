<?php

namespace App\Models\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teachers extends Authenticatable
{
    use Notifiable;

    protected $guard = 'teacher';

    protected $fillable = [
        'name',
        'assigned_school',
        'password',
        'assigned_groups',
        'username',
        'role',
    ];

    protected $hidden =[
        'password',
        'remember_token'
    ];
}
