<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('layouts.Registration.index');
    }

    public function registration(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username|min:6',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|required_with:password_confirm|same:password_confirm|min:6',
            'password_confirm' => 'min:6',
            'agree' => 'required',
        ]);
        DB::beginTransaction();
        try {
            User::insert([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'role' => 'M',
                'created_at' => now('Asia/Jakarta'),
            ]);
            DB::commit();
            return redirect()->route('authentication.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('register.index', ['action' => base64_encode('Failed To Registration')]);
        }
    }
}
