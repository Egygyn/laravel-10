<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function index()
    {
        return  view('auth.login');
    }

    public function forgot_password()
    {
        return  view('auth.forgot-password');
    }

    public function forgot_password_act(Request $request)
    {

        $cutomMessage = [
            'email.required' => 'Email Tidak Boleh Kosong',
            'email.email'    => 'Email Tidak Valid',
            'email.exists'   => 'Email Tidak Terdaftar',

        ];
        $request->validate([
            'email' => 'required|email|exists:users,email'

        ], $cutomMessage);

        $token = \Str::random(60);

        PasswordResetToken::updateOrCreate(
            [
                'email' => $request->email
            ],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        Mail::to($request->email)->send(new ResetPasswordMail($token));

        return redirect()->route('forgot-password')->with('success', 'link recovery cek di email');
    }


    public function validasi_forgot_password_act(Request $request)
    {
        $cutomMessage = [
            'password.required' => 'Password Tidak Boleh Kosong',
            'password.min'      => 'Password Minimal 8 Karakter',
        ];

        $request->validate([
            'password' => 'required|min:8'
        ], $cutomMessage);

        // dd($request->all());
        $token = PasswordResetToken::where('token', $request->token)->first();

        if (!$token) {
            return redirect()->route('login')->with('failled', 'Token Tidak Valid');
        }

        $user = User::where('email', $token->email)->first();

        if (!$user) {
            return redirect()->route('login')->with('failled', 'Email Tidak Terdaftar');
        }
        $user->update([
            'password' => Hash::make($request->password)
        ]);


        $token->delete();

        return redirect()->route('login')->with('succes', 'pasword telah di resset');
    }

    public function validasi_forgot_password(Request $request, $token)
    {
        $getToken = PasswordResetToken::where('token', $token)->first();

        if (!$getToken) {

            return redirect()->route('login')->with('failled', 'Token Tidak Valid');
        }

        return  view('auth.validasi-token', compact('token'));
    }

    public function login_proses(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('login')->with('failled', 'email atau pasword salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('succes', 'kamu berhasil logout');
    }
    public function register()
    {
        return view('auth.register');
    }

    public function register_proses(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        $data['name'] = $request->nama;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);

        User::create($data);

        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($login)) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('login')->with('failled', 'email atau pasword salah');
        }
    }
}
