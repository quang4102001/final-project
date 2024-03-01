<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Jobs\SendMailResetPassword;
use App\Jobs\SendMailWelcomeJob;
use App\Models\Admin;
use App\Models\ResetPassword;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        return view("login");
    }

    public function checkLogin(LoginRequest $request)
    {
        $credentials = $request->safe()->only('username', 'password');

        if (Auth::guard('admin')->attempt(['username' => $credentials['username'], 'password' => $credentials['password'],])) {
            $user = Auth::guard('admin')->user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.index')->with('success', 'Admin login successfully!');
            }
        }

        if (Auth::guard('web')->attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $user = Auth::user();
            if ($user->isUser()) {
                return redirect()->route('home')->with('success', 'User login successfully!');
            }
        }

        return redirect()
            ->back()
            ->withInput($request->safe()->except('password'))
            ->with("error", 'Login failed!');
    }

    public function register()
    {
        return view("register");
    }

    public function checkRegister(RegisterRequest $request)
    {
        try {
            $params = $request->safe()->only(['username', 'name', 'email']);
            $params = array_merge($params, [
                'id' => Str::uuid(),
                'password' => Hash::make($request->safe()->password),
                'role' => 'user',
                'remember_token' => Str::random(64),
            ]);

            $user = User::create($params);

            SendMailWelcomeJob::dispatch($user);
            Auth::login($user);

            return redirect()->route('home')->with('success', 'Login successfully!');
        } catch (\Exception $e) {
            Log::info($e);
            return redirect()
                ->back()
                ->withInput($request->safe()->except('password', 're_password'))
                ->with("error", 'Register failed!');
        }
    }

    public function logoutAdmin()
    {
        Auth::guard('admin')->logout();
        Session::forget('cart');
        return redirect()->route("home")->with("success", "Logout successfully!");
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('cartUser');
        return redirect()->route("home")->with("success", "Logout successfully!");
    }

    public function forgotPassword()
    {
        return view('forgotPassword');
    }

    public function handleForgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $email = $request->safe()->email;
            $token = Str::random(length: 64);

            DB::transaction(function () use ($email, $token) {
                ResetPassword::where('email', $email)->delete();
                ResetPassword::create([
                    'id' => Str::uuid(),
                    'email' => $email,
                    'token' => $token
                ]);
            });

            SendMailResetPassword::dispatch($email, $token);

            return redirect()->route('auth.login')->with('success', 'Have send an email to reset password');
        } catch (\Exception $e) {
            Log::info($e);
            return redirect()->back()
                ->withInput(request()->validated())
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
            $email = $request->safe()->email;
            $password = $request->safe()->password;

            $updatePassword = ResetPassword::where([
                'email' => $email,
                'token' => $token
            ])->first();

            if (!$updatePassword) {
                return redirect()
                    ->back()
                    ->withInput($request->safe()->except('password', 're_password'))
                    ->with('error', "Can not find this account!");
            }

            DB::transaction(function () use ($email, $password) {
                if (Admin::where('email', $email)) {
                    Admin::where('email', $email)->update(['password' => Hash::make($password)]);
                } else {
                    User::where('email', $email)->update(['password' => Hash::make($password)]);
                }
                ResetPassword::where(['email' => $email])->delete();
            });

            return redirect('/login')->with('success', 'Your password has been changed!');
        } catch (\Exception $e) {
            Log::info($e);
            return redirect()
                ->back()
                ->withInput($request->safe()->except('password', 're_password'))
                ->with('error', 'Reset password failed!');
        }
    }

    public function changePassword()
    {
        return view("changePassword");
    }

    public function handleChangePassword(ChangePasswordRequest $request)
    {
        try {
            $old_password = $request->safe()->old_password;
            $new_password = $request->safe()->password;

            if (auth('admin')->check()) {
                $user = auth('admin')->user();
            }
            if (auth()->check()) {
                $user = auth()->user();
            }

            if (!Hash::check($old_password, $user->password)) {
                return redirect()->back()->with('error', 'Mật khẩu cũ không chính xác.');
            }
    
            $user->password = Hash::make($new_password);
            $user->save();

            if (auth('admin')->check()) {
                return redirect()->route('admin.index')->with('success', 'Change password successfully!');
            }

            if (auth()->check()) {
                return redirect()->route('home.index')->with('success', 'Change password successfully!');
            }
        } catch (\Exception $e) {
            Log::info($e);
            return redirect()
                ->back()
                ->with('error', 'Change password failed!');
        }
    }
}
