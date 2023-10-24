<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function index()
    {
        if ((session('auth.role') == "S" && (intval(date('H', time() + 7 * 60 * 60)) >= 8 && intval(date('H', time() + 7 * 60 * 60)) <= 9) == false) || (session('auth.role') == "S" && (intval(date('H', time() + 7 * 60 * 60)) > 16 && intval(date('H', time() + 7 * 60 * 60)) < 18) == false)) {
            return redirect()->route('home')->with('error', '<i class="fas fa-exclamation-triangle"></i> This is not the time for absenteeism');
        }
        $user = User::find(session('auth.id'));
        return view('layouts.User.Absent.index', compact('user'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::find($request->user_id);
            $file = base64_decode($request->photo);
            if (!Storage::exists('attendance/' . $user->first_name . $user->last_name . '/')) {
                Storage::makeDirectory('attendance/' . $user->first_name . $user->last_name . '/');
            }
            $file_path = 'attendance/' . $user->first_name . $user->last_name . '/attendance_' . $request->status . '_' . date('Y-m-d', time() + 7 * 60 * 60) . '.jpeg';
            Storage::put($file_path, $file);
            Attendance::where('user_id', $request->user_id)->where('status', $request->status)->where('created_at', '>', Carbon::now()->startOfDay())->where('created_at', '<', Carbon::now()->endOfDay())->delete();
            $data = $request->except('_token', 'name');
            $data['photo'] = $file_path;
            $data['created_at'] = now('Asia/Jakarta');
            $data['time'] = now('Asia/Jakarta')->addSecond();
            Attendance::insert($data);
            DB::commit();
            return redirect()->route('home')->with('success', '<i class="fas fa-info"></i> &nbsp; Successfully Absent For This Day');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('user.absent')->with('error', '<i class="fas fa-exclamation-triangle"></i> Absent Failed, Please Try again in a while');
        }
    }
    public function all()
    {
        $attendance = Attendance::with('user')->where('created_at', '>', Carbon::now()->startOfMonth())->where('created_at', '<', Carbon::now()->endOfMonth())->get();
        // dd($attendance);
        return view('layouts.User.Absent.all', ['attendance' => json_encode($attendance)]);
    }
}
