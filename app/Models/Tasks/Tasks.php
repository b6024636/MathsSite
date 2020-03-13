<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = [
        'title',
        'rating',
        'marks',
        'is_private',
        'questions',
        'created_by',
        'school',
        'topic',
    ];
}
