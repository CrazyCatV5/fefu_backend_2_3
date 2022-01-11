<?php

namespace App\Http\Controllers;


use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function registration(Request $request) : JsonResponse {
        $request['login'] = strtolower($request['login']);
        $validator = Validator::make($request->all(), [
            'login' => 'required|unique:users|between:5, 30|regex: /^[a-z0-9\-._]+$/i',
            'password' => 'required|between:10, 30|regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&].{10,}$/'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json(['message' => $messages], 422);
        }

        $validated = $validator->validated();
        $user = new User();
        $user->login = $validated['login'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        $token = $user->createToken('token');
        return response()->json(['token' => $token->plainTextToken, 'user' => new UserResource($user)], 201);
    }

    public function login(Request $request) : JsonResponse {
        $request['login'] = strtolower($request['login']);
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json((['message' => $messages]), 422);
        }

        $validated = $validator->validated();

        if (!Auth::attempt(['login' => $validated['login'], 'password' => $validated['password']]))
            return response()->json(['message' => 'Неверный логин или пароль']);

        $user = User::query()
            ->where('login', $validated['login'])
            ->first();

        $token = $user->createToken('token');
        return response()->json(['token' => $token->plainTextToken, 'user' => new UserResource($user)]);
    }

    public function logout(Request $request) : JsonResponse {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Вы вышли из аккаунта']);
    }

    public function profile(Request $request) : JsonResponse {
        return response()->json([new UserResource($request->user())]);
    }
}
