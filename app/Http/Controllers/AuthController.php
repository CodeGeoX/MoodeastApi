<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterAuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public $loginAfterSignUp = true;
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Si se permite el inicio de sesión después del registro, entonces intenta iniciar sesión.
        if ($this->loginAfterSignUp) {
            return $this->login($request);
        }

        // Si no se inicia sesión automáticamente, devuelve una respuesta de registro exitoso.
        return response()->json([
            'status' => 'ok',
            'data' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->accessToken;

            return response()->json([
                'status' => 'ok',
                'token' => $token,
            ]);
        }

        return response()->json([
            'status' => 'invalid_credentials',
            'message' => 'Correo o contraseña no válidos',
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'status' => 'ok',
            'message' => 'Cierre de sesión exitoso.'
        ]);
    }

    public function getAuthUser(Request $request)
    {
        $user = $request->user();
        
        return response()->json(['user' => $user]);
    }

    protected function jsonResponse($data, $code = 200)
    {
        return response()->json($data, $code, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
