<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskFile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'task_id', 'link', 'file', 'created_at', 'updated_at'];

    public function taskUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
