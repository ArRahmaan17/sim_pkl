<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        if (session('auth.role') == "M") {
            $pendingTasks = Task::where('status', 'Pending')->count();
            $progressTasks = Task::where('status', 'Progress')->count();
            $endTasks = Task::where('status', 'End')->count();
        } else {
            $pendingTasks = Task::where('status', 'Pending')->whereJsonContains('group', ["" . session('auth.cluster_id')])->count();
            $progressTasks = Task::where('status', 'Progress')->whereJsonContains('group', ["" . session('auth.cluster_id')])->count();
            $endTasks = Task::where('status', 'End')->whereJsonContains('group', ["" . session('auth.cluster_id')])->count();
        }
        return view('layouts.User.Task.index', compact('pendingTasks', 'progressTasks', 'endTasks'));
    }
    public function store(Request $request)
    {
        if ($request->has('file')) {
            $task_id = implode('', explode(env('APP_URL') . '/user/todo/', url()->previous()));
            if (!Storage::directoryExists('task-file')) {
                Storage::disk('task-file')->makeDirectory('/');
            }
            Storage::disk('task-file')->put('/' . session('auth.username') . '/' . session('auth.id') . '-' . $task_id . '-task-file.' . $request->file('file')->getClientOriginalExtension(), $request->file('file')->getContent());
            return Response()->json(['message' => 'Your task file successfully uploaded'], 200);
        } else {
            DB::beginTransaction();
            try {
                $data = $request->except('_token', 'name');
                $filename = '/' . session('auth.username') . '/' . session('auth.id') . '-' . $request->task_id . '-task-file.zip';
                if (Storage::disk('task-file')->exists($filename)) {
                    $data['file'] = $filename;
                }
                $data['created_at'] = now('Asia/Jakarta');
                TaskFile::insert($data);
                DB::commit();
                return Response()->json(['message' => "Task Updated, You successfully collected the task", 'data' => TaskFile::all()]);
            } catch (\Throwable $th) {
                DB::rollBack();
                //throw $th;
                dd($th);
            }
        }
    }
    public function show($id)
    {
        try {
            $task = Task::with('allFile')->findOrFail(intval($id));
            $countTask = TaskFile::where(['user_id' => session('auth.id')])->count();
            return view('layouts.User.Task.detail', compact('task', 'countTask'));
        } catch (\Throwable $th) {
            return redirect()->route('user.todo.index')->with('error', 'We Cant Find Your Specified Data');
        }
    }
    public function download($id)
    {
        $task = TaskFile::find($id);
        return Storage::disk('task-file')->download($task->file);
    }
}
