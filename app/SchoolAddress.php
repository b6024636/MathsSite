<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolAddress extends Model
{
    protected $fillable = [
        'Address1',
        'Address2',
        'Postcode',
        'County',
        'Country',
    ];
}
