<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Model;

class TaskCompleted extends Model
{
    protected $fillable = [
        'student_id',
        'task_id',
        'marks_per_question',
        'total_marks_earned',
    ];
}
