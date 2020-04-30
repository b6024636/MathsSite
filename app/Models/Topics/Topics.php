<?php

namespace App\Models\Topics;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    protected $fillable = [
        'title',
        'icon',
    ];
}