<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $pendingTasks = Task::where('status', 'Pending')->whereJsonContains('group', ["" . session('auth.cluster_id')])->count();
        $progressTasks = Task::where('status', 'Progress')->whereJsonContains('group', ["" . session('auth.cluster_id')])->count();
        $endTasks = Task::where('status', 'End')->whereJsonContains('group', ["" . session('auth.cluster_id')])->count();
        return view('layouts.User.Task.index', compact('pendingTasks', 'progressTasks', 'endTasks'));
    }
    public function show($id)
    {
        try {
            $task = Task::findOrFail(intval($id));
            return view('layouts.User.Task.detail', compact('task'));
        } catch (\Throwable $th) {
            return redirect()->route('user.todo.index')->with('error', 'We Cant Find Your Specified Data');
        }
    }
}
