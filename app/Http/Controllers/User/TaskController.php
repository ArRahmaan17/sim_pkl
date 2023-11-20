<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskFile;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
                $data['cluster_id'] = session('auth.cluster_id');
                $data['evidence_file'] = $data['file'];
                $task = Task::find($request->task_id);
                $task_activity = Todo::where(['task_id' => $request->task_id, 'user_id' => session('auth.id')])->orderBy('id', 'desc')->first();
                $data['description'] = session('auth.first_name') . " " . session('') . " update to done task " . $task->title;
                $data['status'] = "Done";
                $data['progress'] = 100;
                $data['finish'] = now('Asia/Jakarta');
                $data['start'] = $task_activity->start;
                unset($data['file'], $data['link']);
                Todo::insert($data);
                DB::commit();
                return Response()->json([
                    'message' => "Task Updated, You successfully collected the task",
                    'data' => TaskFile::all(),
                    'activities_data' => Todo::where([
                        'task_id' => $request->task_id,
                        'user_id' => $request->user_id
                    ])->orderBy('id', 'desc')->get()
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                //throw $th;
                dd($th);
            }
        }
    }
    public function start(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($request->user_id);
            $task = Task::findOrFail($request->task_id);
            $data = $request->all();
            $data['created_at'] = now('Asia/Jakarta');
            $data['cluster_id'] = $user->cluster_id;
            $data['start'] = now('Asia/Jakarta');
            $data['progress'] = 10;
            Todo::insert($data);
            DB::commit();
            return Response()->json([
                'message' => "Task Started, Please store your work files before " . $task->deadline_date . ' 23:59:59',
                'activities_data' => Todo::where([
                    'task_id' => $request->task_id,
                    'user_id' => $request->user_id
                ])->orderBy('id', 'desc')->get()
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            dd($th);
        }
    }
    public function show($id)
    {
        try {
            $task = Task::with('allFile')->findOrFail(intval($id));
            $countTask = TaskFile::where(['user_id' => session('auth.id'), 'task_id' => $id])->count();
            $countStartTask = Todo::where(['task_id' => $id, 'user_id' => session('auth.id'), 'status' => 'Started'])->count();
            $activity_task = Todo::where(['task_id' => $id, 'user_id' => session('auth.id')])->orderBy('id', 'desc')->get();
            return view('layouts.User.Task.detail', compact('task', 'countTask', 'countStartTask', 'activity_task'));
        } catch (\Throwable $th) {
            return redirect()->route('user.todo.index')->with('error', 'We Cant Find Your Specified Data');
        }
    }
    public function activity_update(Request $request)
    {
        if ($request->has('activity_photos')) {
            $task_id = implode('', explode(env('APP_URL') . '/user/todo/', url()->previous()));
            if (!Storage::directoryExists('task-activity')) {
                Storage::disk('task-activity')->makeDirectory('/');
            }
            $last_activity = Todo::where(['user_id' => session('auth.id'), 'task_id' => $task_id])->orderBy('id', 'desc')->limit(1)->first();
            if ($last_activity->status == "Started") {
                $status = "Analysis";
            } else if ($last_activity->status == "Analysis") {
                $status = "Development";
            }
            Storage::disk('task-activity')->put('/' . session('auth.username') . '/' . session('auth.id') . '-' . $task_id . '-task-' . Str::lower($status) . '-activity.' . $request->file('activity_photos')->getClientOriginalExtension(), $request->file('activity_photos')->getContent());
            return Response()->json(['message' => 'Your activity photos successfully uploaded', 'extension' => $request->file('activity_photos')->getClientOriginalExtension()], 200);
        } else {
            DB::beginTransaction();
            try {
                $data = $request->except('_token', 'extension', 'name');
                $filename = '/' . session('auth.username') . '/' . session('auth.id') . '-' . $request->task_id . '-task-' . Str::lower($request->status) . '-activity.' . $request->extension;
                if (Storage::disk('task-activity')->exists($filename)) {
                    $data['evidence_file'] = $filename;
                }
                $data['created_at'] = now('Asia/Jakarta');
                $data['cluster_id'] = session('auth.cluster_id');
                Todo::insert($data);
                DB::commit();
                return Response()->json([
                    'message' => "Activity Updated, We wait for your next update activity",
                    'activities_data' => Todo::where([
                        'task_id' => $request->task_id,
                        'user_id' => $request->user_id
                    ])->orderBy('id', 'desc')->get()
                ], 200);
            } catch (\Throwable $th) {
                DB::rollBack();
                //throw $th;
                dd($th);
            }
        }
    }
    public function download($id)
    {
        $task = TaskFile::find($id);
        return Storage::disk('task-file')->download($task->file);
    }
}
