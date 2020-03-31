<?php

namespace App\Models\Groups;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $fillable = [
        'code',
        'assigned_school',
        'assigned_tasks',
    ];
}
