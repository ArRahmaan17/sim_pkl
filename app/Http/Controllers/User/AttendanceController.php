<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Task;
use App\Models\Todo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function index()
    {
        if (session('auth.role') == "S") {
            if (
                (intval(date('H', time() + 7 * 60 * 60)) == 7 || intval(date('H', time() + 7 * 60 * 60)) == 8 || intval(date('H', time() + 7 * 60 * 60)) == 9) ||
                (intval(date('H', time() + 7 * 60 * 60)) == 16)
            ) {
                $user = User::find(session('auth.id'));
                $history = Attendance::attendance_history(session('auth.id'));
                return view('layouts.User.Absent.index', compact('user', 'history'));
            } else {
                return redirect()->route('home.index')->with('error', '<i class="fas fa-exclamation-triangle"></i> This is not the time for attendance');
            }
        } else {
            $user = User::find(session('auth.id'));
            $history = Attendance::attendance_history(session('auth.id'));
            return view('layouts.User.Absent.index', compact('user', 'history'));
        }
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::find($request->user_id);
            $file = base64_decode($request->photo);
            if (!Storage::exists('attendance/' . $user->id . '/')) {
                Storage::makeDirectory('attendance/' . $user->id . '/');
            }
            $file_path =  $user->id . '/attendance_' . $request->status . '_' . date('Y-m-d', time() + 7 * 60 * 60) . '.jpeg';
            Storage::disk('attendance')->put($file_path, $file);
            Attendance::where('user_id', $request->user_id)
                ->where('status', $request->status)
                ->where('created_at', '>', Carbon::now('Asia/Jakarta')->startOfDay())
                ->where('created_at', '<', Carbon::now('Asia/Jakarta')->endOfDay())
                ->delete();
            $data = $request->except('_token', 'name');
            $data['photo'] = $file_path;
            $data['created_at'] = now('Asia/Jakarta');
            $data['time'] = now('Asia/Jakarta')->addSecond();
            $attendance = Attendance::insertGetId($data);
            DB::commit();
            Artisan::call('app:send-attendance-success-notification', ['attendance-id' => $attendance]);
            return redirect()->route('home.index')->with('success', '<i class="fas fa-info"></i> &nbsp; Successfully Absent For This Day');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return redirect()->route('user.attendance.index')->with('error', '<i class="fas fa-exclamation-triangle"></i> Absent Failed, Please Try again in a while');
        }
    }

    public function map()
    {
        $attendance = Attendance::with('user');
        if (session('auth.role') == 'S') {
            $attendance = $attendance->where('user_id', session('auth.id'))->get()->map(function ($absent) {
                $absent->photo = attendance_asset($absent->photo);
                return $absent;
            });;
        } else {
            $attendance = $attendance->get()->map(function ($absent) {
                $absent->photo = attendance_asset($absent->photo);
                return $absent;
            });
        }
        return view('layouts.User.Absent.map', [
            'attendance' => $attendance,
        ]);
    }

    public function all()
    {
        $attendance = Attendance::with('user')->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth());
        $todos = Todo::where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth());
        if (session('auth.role') == 'S') {
            $attendance = $attendance->where('user_id', session('auth.id'))->get();
            $todos = $todos->where('user_id', session('auth.id'))->get();
        } else {
            $attendance = $attendance->get();
            $todos = $todos->get();
        }
        return view('layouts.User.Absent.all', [
            'attendance' => $attendance,
            'todos' => $todos,
        ]);
    }
}
