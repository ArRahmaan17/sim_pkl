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
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(session('auth.id'));
        // dd($user);
        return view('layouts.User.Profile.index', compact('user'));
    }

    public function update_profile_picture(Request $request)
    {
        $profile_picture = $request->file('file');
        $filename = session('auth.username') . '/' . session('auth.first_name') . session('auth.last_name') . '.' . $profile_picture->getClientOriginalExtension();
        if (Storage::disk('profile-picture')->exists('/')) {
            Storage::disk('profile-picture')->makeDirectory('/');
        }
        DB::beginTransaction();
        try {
            Storage::disk('profile-picture')->put($filename, $profile_picture->getContent());
            User::find(session('auth.id'))->update([
                'profile_picture' => $filename
            ]);
            DB::commit();
            return Response()->json([
                'message' => 'Profile picture update successfully',
                'profile_picture' => 'data:image/png;base64,' . profile_asset($filename)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return Response()->json([
                'message' => 'Failed to update profile picture'
            ], 500);
        }
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
            return redirect()->route('user.profile.index')->with('try_again', 'Really Bro You Try Again?');
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
            Mail::to($request->email)
                ->send(new ChangePasswordMail(User::where('email', $request->email)->first()));
            ChangePassword::where('email', $request->email)->update(['mailed' => true]);
            DB::commit();
            return redirect()->route('user.profile.index')->with('email', 'Check your email to complete process change password');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function accept_changed_password(Request $request)
    {
        DB::beginTransaction();
        try {
            $request_change_password = ChangePassword::where([
                'email' => base64_decode($request->action),
                'mailed' => 1,
                'changed' => 0
            ]);
            if (
                $request->validation == env('APP_VALIDATION') &&
                $request_change_password->count() == 1
            ) {
                $request_change_password->update(['changed' => true]);
                $message = ['success', 'Successfully Change Your Password'];
            } else {
                $message = ['error', 'Your Validation Key Is invalid'];
            }
            DB::commit();
            return redirect()->route('user.profile.index')->with($message[0], $message[1]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $message = ['error', 'Unexpected Error on change password process'];
            return redirect()->route('user.profile.index')->with($message[0], $message[1]);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|alpha_num|unique:users,username,' . session('auth.id') . '',
            'first_name' => 'required|regex:/[^0-9]+/',
            'last_name' => 'required|regex:/[^0-9]+/',
            'address' => 'required',
            'email' => 'required|unique:users,email,' . session('auth.id') . '',
            'phone_number' => 'required|numeric',
            'gender' => 'required',
        ]);
        DB::beginTransaction();
        try {
            User::find(session('auth.id'))->update($request->except('_token'));
            DB::commit();
            $data['auth'] = User::find(session('auth.id'));
            $data['auth']['logged'] = true;
            session($data);
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
