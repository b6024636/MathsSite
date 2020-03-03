<?php

namespace App\Models\Schools;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

/**
 * Post
 *
 * @mixin Eloquent
 */
class SchoolAddress extends Model
{
    public function school()
    {
        return $this->belongsTo('App\Models\Schools\School');
    }

    protected $fillable = [
        'Address1',
        'Address2',
        'Postcode',
        'County',
        'Country',
    ];
}
