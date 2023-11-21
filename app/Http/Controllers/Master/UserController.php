<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $students = User::where(['role' => 'S'])->get();
        return view('layouts.Mentor.User.index', compact('students'));
    }
}
