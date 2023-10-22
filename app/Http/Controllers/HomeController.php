<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $month = $request->month ?? Carbon::now()->month;
        $in = Attendance::where('created_at', '>', Carbon::now()->month($month)->firstOfMonth()->format('Y-m-d H:i:s') . '.000')->where('created_at', '<', Carbon::now()->month($month)->lastOfMonth()->format('Y-m-d H:i:s') . '.000')->where('status', 'IN')->count();
        $sick = Attendance::where('created_at', '>', Carbon::now()->month($month)->firstOfMonth()->format('Y-m-d H:i:s') . '.000')->where('created_at', '<', Carbon::now()->month($month)->lastOfMonth()->format('Y-m-d H:i:s') . '.000')->where('status', 'SICK')->count();
        $absent = Attendance::where('created_at', '>', Carbon::now()->month($month)->firstOfMonth()->format('Y-m-d H:i:s') . '.000')->where('created_at', '<', Carbon::now()->month($month)->lastOfMonth()->format('Y-m-d H:i:s') . '.000')->where('status', 'ABSENT')->count();
        $month = Carbon::now()->month($month)->monthName;
        return view('layouts.home', compact('in', 'sick', 'absent', 'month'));
    }
}
