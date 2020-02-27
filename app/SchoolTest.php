<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolTest extends Model
{
    protected $fillable = [
        'name',
        'address',
        'contact',
        'description',
    ];
}
