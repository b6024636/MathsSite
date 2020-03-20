<?php

namespace App\Models\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Students extends Authenticatable
{
    use Notifiable;

    protected $guard = 'student';

    protected $fillable = [
        'student_id',
        'assigned_school',
        'password',
        'assigned_groups',
        'completed_tasks',
        'outstanding_tasks',
    ];

    protected $hidden =[
        'password',
        'remember_token'
    ];
}
