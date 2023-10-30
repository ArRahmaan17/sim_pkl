<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    public function index()
    {
        list($yearStart, $monthStart, $dayStart) = explode('-', explode(',', env('APP_RANGE'))[0]);
        list($yearEnd, $monthEnd, $dayEnd) = explode('-', explode(',', env('APP_RANGE'))[1]);
        $startDate = now('Asia/Jakarta')->setDate($yearStart, $monthStart, $dayStart)->startOfDay();
        $endDate = now('Asia/Jakarta')->setDate($yearEnd, $monthEnd, $dayEnd)->endOfDay();
        $clusters = Cluster::all();
        return view('layouts.Mentor.Task.index', compact('startDate', 'endDate', 'clusters'));
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
            if (!Storage::directoryExists('/task')) {
                Storage::makeDirectory('task');
            }
            $filename = Str::slug($request->title, '-') . '-' . $request->deadline_date;
            $extension = $request->file('image')->extension();
            Storage::disk('task')->put($filename . '.' . $extension, $request->file('image')->getContent());
            $data = $request->except('_token', 'image');
            $data['thumbnail'] = $filename . '.' . $extension;
            $data['group'] = json_encode($data['group']);
            Task::create($data);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }
}
