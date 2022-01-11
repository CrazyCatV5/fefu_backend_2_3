<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebAuthController extends Controller
{
    public function registration(Request $request) {
        if ($request->isMethod('post')) {
            $request['login'] = strtolower($request['login']);
            $validated = $request->validate([
                'login' => 'required|unique:users|between:5, 30|regex: /^[a-z0-9\-._]+$/i',
                'password' => 'required|between:10, 30|regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&].{10,}$/'
            ]);

            $user = new User();
            $user->login = $validated['login'];
            $user->password = Hash::make($validated['password']);
            $user->save();
            Auth::login($user);
            return redirect()->route('profile');
        } else
            return view('auth/registration');
    }

    public function login(Request $request) {
        $request['login'] = strtolower($request['login']);
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'login' => 'required',
                'password' => 'required'
            ]);

            if (Auth::attempt($validated)) {
                $request->session()->regenerate();
                return redirect()
                    ->route('profile');
            }
            return redirect()
                ->route('login')->with('error', 'Неправильный логин или пароль');

        } else
            return view('auth/login');
    }

    public function logout() {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/login');
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        return view('auth/profile', ['user'=>new UserResource($user)]);
    }
}

