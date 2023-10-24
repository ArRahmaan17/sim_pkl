<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('layouts.Authentication.index');
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'credential' => 'required',
                'password' => 'required',
            ],
            [
                'credential.required' => 'The email / username is required'
            ]
        );
        $user = User::where('username', $request->credential)->orWhere('email', $request->credential);
        if ($user->count() == 1 && Hash::check($request->password, $user->first()->password)) {
            $data['auth'] = $user->first();
            $data['auth']['logged'] = true;
            session($data);
            return redirect('/');
        };
        return redirect()->route('authentication.index');
    }
    public function logout()
    {
        session()->flush();
        return redirect()->route('home');
    }
}
