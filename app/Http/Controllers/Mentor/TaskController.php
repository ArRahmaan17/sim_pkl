<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use App\Models\Task;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    public function index()
    {
        [$yearStart, $monthStart, $dayStart] = explode('-', explode(',', env('APP_RANGE'))[0]);
        [$yearEnd, $monthEnd, $dayEnd] = explode('-', explode(',', env('APP_RANGE'))[1]);
        $startDate = now('Asia/Jakarta')->setDate($yearStart, $monthStart, $dayStart)->startOfDay();
        $endDate = now('Asia/Jakarta')->setDate($yearEnd, $monthEnd, $dayEnd)->endOfDay();
        $clusters = Cluster::all();
        $pendingTasks = Task::where('status', 'Pending')->count();
        $progressTasks = Task::where('status', 'Progress')->count();
        $endTasks = Task::where('status', 'End')->count();

        return view('layouts.Mentor.Task.index', compact('startDate', 'endDate', 'clusters', 'pendingTasks', 'progressTasks', 'endTasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'deadline_date' => 'required|date',
            'group' => 'required|array',
            'content' => 'required',
            'image' => 'required|image',
            'status' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $filename = Str::slug($request->title, '-').'-'.$request->deadline_date;
            $extension = $request->file('image')->extension();
            $data = $request->except('_token', 'image');
            $data['thumbnail'] = $filename.'.'.$extension;
            $data['created_at'] = now('Asia/Jakarta');
            $data['group'] = json_encode($data['group']);
            $task = Task::insertGetId($data);
            $phone_numbers = [];
            $todos = [];
            foreach (json_decode($data['group']) as $key => $group) {
                $users = User::where(['group_id' => $group, 'role' => 'S'])->get();
                foreach ($users as $key => $user) {
                    array_push($phone_numbers, implode('', explode('(+62)', implode('', explode(' ', $user->phone_number)))));
                    array_push($todos, [
                        'user_id' => $user->id,
                        'description' => $user->first_name.' '.$user->last_name.' shared task '.$data['title'],
                        'group_id' => intval($group),
                        'task_id' => $task,
                        'status' => 'Shared',
                        'created_at' => now('Asia/Jakarta'),
                    ]);
                }
            }
            Todo::insert($todos);
            DB::commit();
            if (! Storage::directoryExists('/task')) {
                Storage::makeDirectory('task');
            }
            Storage::disk('task')->put($filename.'.'.$extension, $request->file('image')->getContent());
            if (env('WA_SERVICES_STATUS')) {
                Http::attach(
                    'task_thumbnail',
                    Storage::disk('task')->get($filename.'.'.$extension),
                    'photo.jpg'
                )->post(env('WA_SERVICES').'task-notification', [
                    'title' => $request->title,
                    'phone_numbers' => json_encode($phone_numbers),
                ]);
            }

            return Response()->json(['message' => 'Successfully create task', 'data' => Task::orderBy('created_at')->get()->chunk(5)], 200);
        } catch (\Throwable $th) {

            DB::rollBack();
            dd($th);

            return Response()->json(['message' => 'Failed create task'], 500);
        }
    }

    public function show($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->thumbnail = tasks_asset($task->thumbnail);

            return Response()->json(['message' => 'Task found', 'data' => $task], 200);
        } catch (\Throwable $th) {
            if ($th->getCode() == 0) {
                return Response()->json(['message' => 'Task not found', 'data' => []], 404);
            }
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'deadline_date' => 'required|date',
            'group' => 'required|array',
            'content' => 'required',
            'status' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->except('_token', 'image');
            if ($request->file('image') !== null) {
                $filename = Str::slug($request->title, '-').'-'.$request->deadline_date;
                $extension = $request->file('image')->extension();
                $data['thumbnail'] = $filename.'.'.$extension;
                Storage::disk('task')->put($filename.'.'.$extension, $request->file('image')->getContent());
            }
            $data['group'] = json_encode($data['group']);
            Task::find($id)->update($data);
            DB::commit();

            return Response()->json(['message' => 'Successfully update task '.$request->title, 'data' => Task::orderBy('created_at')->get()->chunk(5)], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return Response()->json(['message' => 'Failed update task '.$request->title], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            Task::find($id)->delete();
            DB::commit();

            return Response()->json(['message' => 'Successfully delete task', 'data' => Task::orderBy('created_at')->get()->chunk(5)], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return Response()->json(['message' => 'Failed delete task'], 500);
        }
    }
}
