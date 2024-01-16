<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\DailyProgress;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    public function index()
    {
        $dailyProgress = DailyProgress::where('user_id', (session('auth.role') == 'M') ?  '<>' : '=', (session('auth.role') == 'M') ? 0 : session('auth.user_id'))->get();
        return view('layouts.Report.Daily.index', compact('dailyProgress'));
    }
}
