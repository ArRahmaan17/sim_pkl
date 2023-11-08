<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Task;
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
    public function all_student_task($cluster_id, $role)
    {
        if ($role == "M") {
            $tasks = Task::orderBy('created_at')->get()->map(function ($task, $index) {
                $task->thumbnail = tasks_asset($task->thumbnail);
                return $task;
            });
        } else {
            $tasks = Task::whereJsonContains('group', ["" . $cluster_id])->orderBy('created_at')->get()->map(function ($task, $index) {
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
