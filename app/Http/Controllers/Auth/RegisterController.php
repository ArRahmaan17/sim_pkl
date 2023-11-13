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
    public function students_index()
    {
        return view('layouts.Registration.Student.index');
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
    public function student_registration(Request $request)
    {
        $request->validate([
            'first_name' => 'required|regex:/[^0-9]+/|max:15',
            'last_name' => 'required|regex:/[^0-9]+/|max:15',
            'student_identification_number' => 'required|max:15',
            'phone_number' => 'required|max:13',
            'address' => 'required',
            'gender' => 'required',
            'username' => 'required|unique:users,username|min:6|alpha_num',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|required_with:password_confirm|same:password_confirm|min:6',
            'password_confirm' => 'min:6',
            'agree' => 'required',
        ], [
            'student_identification_number.required' => 'The NIS field is required.',
            'first_name.regex' => 'The first name field must not contain number.',
            'last_name.regex' => 'The last name field must not contain number.',
            'student_identification_number.max' => 'The NIS field must not be greater than 15 characters.'
        ]);
        DB::beginTransaction();
        try {
            $data = $request->except('_token', 'agree', 'password_confirm');
            $data['created_at'] = now('Asia/Jakarta');
            $data['password'] = Hash::make($request->password);
            $data['role'] = "S";
            User::insert($data);
            DB::commit();
            return redirect()->route('authentication.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('register.index', ['action' => base64_encode('Failed To Registration')]);
        }
    }
}
