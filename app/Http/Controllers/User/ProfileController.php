<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\ChangePasswordMail;
use App\Models\ChangePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(session('auth.id'));
        return view('layouts.User.Profile.index', compact('user'));
    }

    public function last_change_password($id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            if ($user->last_reset_password == date('Y-m-d')) {
                session(['handle.counter_change_password' => 1]);
                return Response()->json(['message' => 'Good Skill, But not this time'], 500);
            }
            session(['handle.counter_change_password' => null]);
            $user->update([
                'last_reset_password' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta')
            ]);
            DB::commit();
            return Response()->json(['message' => 'Successfully update last reset password']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Response()->json(['message' => 'Failed update last reset password'], 500);
        }
    }
    public function change_password()
    {
        $user = User::find(session('auth.id'));
        if (session('handle.counter_change_password') != null) {
            return redirect()->route('user.profile')->with('try_again', 'Really Bro You Try Again?');
        }
        return view('layouts.User.Profile.change-password');
    }

    public function changing_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|required_with:password_confirm|same:password_confirm|min:6',
            'password_confirm' => 'required|min:6',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->except('_token', 'password_confirm');
            $data['created_at'] = now('Asia/Jakarta');
            $data['password'] = Hash::make($request->password);
            ChangePassword::insert($data);
            DB::commit();
            Mail::to('sardhi17feb2018@gmail.com')->send(new ChangePasswordMail());
            return redirect()->route('user.profile')->with('email', 'Check your email to complete process change password');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . session('auth.id') . '',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => 'required|unique:users,email,' . session('auth.id') . '',
            'phone_number' => 'required',
            'gender' => 'required',
        ]);
        DB::beginTransaction();
        try {
            User::find(session('auth.id'))->update($request->except('_token'));
            DB::commit();
            return Response()->json([
                'message' => 'Successfully update your profile',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return Response()->json([
                'message' => 'Failed update your profile',
            ], 500);
        }
    }
}
