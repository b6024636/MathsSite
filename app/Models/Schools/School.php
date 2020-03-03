<?php

namespace App\Models\Schools;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    public function address()
    {
        return $this->hasOne('App\Models\Schools\SchoolAddress');
    }

    protected $fillable = [
        'Name',
        'Address_id',
        'Contact_Number',
        'Email',
        'Approved_By',
        'Pending',
        'Logo',
    ];
}
