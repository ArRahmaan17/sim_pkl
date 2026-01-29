<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
        'description',
        'group_id',
        'task_id',
        'start',
        'progress',
        'status',
        'finish',
        'evidence_file',
        'created_at',
        'updated_at',
    ];
}
