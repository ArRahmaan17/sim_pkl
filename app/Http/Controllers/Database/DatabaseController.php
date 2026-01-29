<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Todo;
use App\Models\User;

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

    public function users_all()
    {
        $users = User::where(['role' => 'S'])->get();
        $users = collect($users)->chunk(5);
        if (count($users) == 0) {
            return Response()->json(['message' => 'Users record not found', 'data' => $users], 404);
        } else {
            return Response()->json(['message' => 'Found users record ', 'data' => $users], 200);
        }
    }

    public function detail_user($id)
    {
        $user = User::where(['role' => 'S', 'id' => $id])->first();
        if (empty($user)) {
            return Response()->json(['message' => 'User record not found', 'data' => $user], 404);
        } else {
            $user->profile_picture = 'data:image/jpeg;base64,'.profile_asset(($user->profile_picture != null) ? $user->profile_picture : 'img/avatar/avatar-2.png');

            return Response()->json(['message' => 'Found user record', 'data' => $user], 200);
        }
    }

    public function show_task_progress($task_id)
    {
        $activities = Todo::where(['task_id' => $task_id, 'user_id' => session('auth.id')])->orderBy('id', 'desc')->limit(1);
        if ($activities->count() > 0) {
            return Response()->json(['message' => 'We found your task activity', 'data' => $activities->first()], 200);
        } else {
            return Response()->json(['message' => "We can't found your task activity", 'data' => $activities->first()], 404);
        }
    }

    public function all_student_task($role, $group_id)
    {
        if ($role == 'M') {
            $tasks = Task::with('last_activity')->orderBy('created_at')->get()->map(function ($task, $index) {
                $task->thumbnail = tasks_asset($task->thumbnail);

                return $task;
            });
        } else {
            $tasks = Task::with('last_activity')->whereJsonContains('group', [''.$group_id])->orderBy('created_at')->get()->map(function ($task, $index) {
                $task->thumbnail = tasks_asset($task->thumbnail);

                return $task;
            });
        }
        // dd($tasks[1]->last_activity);
        // dd(Task::with('last_activity')->whereJsonContains('group', ["" . $group_id])->orderBy('created_at')->dd());
        $tasks = collect($tasks)->chunk(5);
        if (count($tasks) == 0) {
            return Response()->json(['message' => 'Tasks record not found', 'data' => $tasks], 404);
        } else {
            return Response()->json(['message' => 'Found tasks record ', 'data' => $tasks], 200);
        }
    }
}
