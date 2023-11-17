<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Todo;
use Illuminate\Http\Request;

class DatabaseController extends Controller
{
    public function tasks_all()
    {
        $tasks = Task::orderBy('created_at')->get()->toArray();
        $tasks = collect($tasks)->chunk(5);
        if (count($tasks) == 0) {
            return Response()->json(['message' => 'Tasks record not found', 'data' => $tasks], 404);
        } else {
            return Response()->json(['message' => 'Found tasks record ', 'data' => $tasks], 200);
        }
    }
    public function show_task_progress($task_id)
    {
        $activities = Todo::where(['task_id' => $task_id, 'user_id' => session('auth.id')])->orderBy('id', 'desc')->limit(1);
        if ($activities->count() > 0) {
            return Response()->json(['message' => "We found your task activity", 'data' => $activities->first()], 200);
        } else {
            return Response()->json(['message' => "We can't found your task activity", 'data' => $activities->first()], 404);
        }
    }
    public function all_student_task($role, $cluster_id)
    {
        if ($role == "M") {
            $tasks = Task::with('last_activity')->orderBy('created_at')->get()->map(function ($task, $index) {
                $task->thumbnail = tasks_asset($task->thumbnail);
                return $task;
            });
        } else {
            $tasks = Task::with('last_activity')->whereJsonContains('group', ["" . $cluster_id])->orderBy('created_at')->get()->map(function ($task, $index) {
                $task->thumbnail = tasks_asset($task->thumbnail);
                return $task;
            });
        }
        $tasks = collect($tasks)->chunk(5);
        if (count($tasks) == 0) {
            return Response()->json(['message' => 'Tasks record not found', 'data' => $tasks], 404);
        } else {
            return Response()->json(['message' => 'Found tasks record ', 'data' => $tasks], 200);
        }
    }
}
