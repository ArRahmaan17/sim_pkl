<?php

namespace App\Models;

use App\Events\TaskEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'created' => TaskEvent::class,
    ];

    protected $fillable = [
        'title',
        'start_date',
        'deadline_date',
        'group',
        'content',
        'thumbnail',
        'status',
        'created_at',
        'updated_at',
    ];

    public function allFile()
    {
        return $this->hasMany(TaskFile::class, 'task_id', 'id');
    }

    public function last_activity()
    {
        return $this->hasOne(
            Todo::class,
            foreignKey: 'task_id',
            localKey: 'id'
        )->where('todos.user_id', session('auth.id'))->orderByDesc('todos.id');
    }
}
