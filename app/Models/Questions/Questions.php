<?php

namespace App\Models\Questions;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $fillable = [
        'Type',
        'Description',
        'Marks',
        'Image',
        'Answer',
        'Optional_Answers',
        'Is_Private',
        'School',
        'CreatedBy',
        'Question',
        'topic'
    ];
}
