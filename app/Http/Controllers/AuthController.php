<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        return view("login");
    }

    public function checkLogin(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('admin')->attempt(['username' => $credentials['username'], 'password' => $credentials['password'],], $request->has('remember'))) {
            $user = Auth::guard('admin')->user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.index')->with('success', 'Admin login successfully!');
            }
        }

        if (Auth::guard('web')->attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $request->has('remember'))) {
            $user = Auth::user();

            if ($user->role === 'user') {
                return redirect()->route('home')->with('success', 'User login successfully!');
            }
        }

        return redirect()
            ->back()
            ->withInput($request->except('password'))
            ->with("error", 'Login failed!');
    }

    public function register()
    {
        return view("register");
    }

    public function checkRegister(RegisterRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'id' => Str::uuid(),
                    'username' => $request->input('username'),
                    'name' => $request->input('name'),
                    'password' => Hash::make($request->input('password')),
                    'email' => $request->input('email'),
                    'role' => 'user',
                    'remember_token' => Str::random(64),
                ]);

                Auth::login($user);
            });

            return redirect()->route('home')->with('success', 'Login successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput($request->except('password', 'rePassword'))
                ->with("error", 'Register failed!');
        }
    }

    public function logoutAdmin()
    {
        Auth::guard('admin')->logout();
        return redirect()->route("home")->with("success", "Logout successfully!");
    }

    public function logout()
    {
        Auth::logout();
        Cookie::queue(Cookie::forget('cart'));
        return redirect()->route("home")->with("success", "Logout successfully!");
    }

    public function forgotPassword()
    {
        return view('forgotPassword');
    }

    public function handleForgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $token = Str::random(length: 64);

            DB::transaction(function () use ($request, $token) {
                ResetPassword::create([
                    'id' => Str::uuid(),
                    'email' => $request->email,
                    'token' => $token
                ]);
            });

            Mail::send('home.emails.linkResetPassword', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            return redirect()->route('auth.login')->with('success', 'Have send an email to reset password');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput(request()->all())
                ->with("error", 'Send email failed!');
        }
    }

    public function resetPassword($token)
    {
        return view('resetPassword', ['token' => $token]);
    }

    public function handleResetPassword(ResetPasswordRequest $request, string $token)
    {
        try {
            $updatePassword = ResetPassword::where([
                'email' => $request->email,
                'token' => $token
            ])->first();

            if (!$updatePassword) {
                return redirect()
                    ->back()
                    ->withInput($request->except('password', 'rePassword'))
                    ->with('error', "Can not find this account!");
            }

            DB::transaction(function () use ($request) {

                User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
                ResetPassword::where(['email' => $request->email])->delete();
            });

            return redirect('/login')->with('success', 'Your password has been changed!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput($request->except('password', 'rePassword'))
                ->with('error', 'Reset password failed!');
        }
    }
}
