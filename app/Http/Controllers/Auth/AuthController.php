<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('layouts.Authentication.login');
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'credential' => 'required',
                'password' => 'required',
            ],
            [
                'credential.required' => 'The email / username is required',
            ]
        );
        $user = User::where('username', $request->credential)->orWhere('email', $request->credential);
        if ($user->count() == 1 && Hash::check($request->password, $user->first()->password)) {
            User::find($user->first()->id)->update(['last_login' => now('Asia/Jakarta')]);
            $data['auth'] = $user->first();
            $data['auth'] = profile_asset($data['auth']['profile_picture']);
            $data['auth']['logged'] = true;
            session($data);

            return redirect('/');
        }

        return redirect()->route('authentication.index');
    }

    public function registration()
    {
        return view('layouts.Authentication.registration');
    }

    public function registrating(Request $request)
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

    public function logout()
    {
        session()->flush();

        return redirect()->route('home.index');
    }
}
