<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class DatabaseController extends Controller
{
    public function tasks_all()
    {
        $tasks = Task::get()->toArray();
        $tasks = collect($tasks)->chunk(5);
        if (count($tasks) == 0) {
            return Response()->json(['message' => 'Tasks record not found', 'data' => $tasks], 404);
        } else {
            return Response()->json(['message' => 'Found tasks record ', 'data' => $tasks], 200);
        }
    }
}
