<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterAuthRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public $loginAfterSignUp = true;

    public function __construct()
{
    $this->middleware('auth:sanctum')->except(['register', 'login']);
}


    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            if ($this->loginAfterSignUp) {
                return $this->login($request);
            }
            $token = $user->createToken('NombreDelToken')->plainTextToken;
            return response()->json([
                'status' => 'ok',
                'name' => $user->name,
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al registrar el usuario.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getUserInfo(Request $request)
    {
        try {
            $user = $request->user();

            if ($user) {
                return response()->json([
                    'status' => 'ok',
                    'user' => $user,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Usuario no autenticado',
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener la información del usuario.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        $user = Auth::user();
        
        $token = $user->createToken('NombreDelToken')->plainTextToken;

        return response()->json([
            'status' => 'ok',
            'token' => $token,
            'name' => $user->name,
        ]);
    }

    return response()->json([
        'status' => 'error',
        'message' => 'Credenciales no válidas',
    ], 401);
}


    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'status' => 'ok',
            'message' => 'Cierre de sesión exitoso.',
        ]);
    }

    public function getAuthUser(Request $request)
    {
        $user = $request->user();

        return response()->json(['user' => $user]);
    }

    public function updateName(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
    
            $user = $request->user();
            if ($user) {
                print("El nombre es: " . $user->name);
            } else {
                print("El usuario es nulo");
            }
            
            $user->name = $request->name;
            $user->save();
    
            return response()->json([
                'status' => 'ok',
                'message' => 'Nombre de usuario actualizado exitosamente.',
                'name' => $user->name, // Incluimos el nombre actualizado en la respuesta
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar el nombre de usuario.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    
    

    public function getUserName(Request $request)
    {
        if ($request->user()) {
            $user = $request->user();
            return response()->json(['status' => 'ok', 'name' => $user->name]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Usuario no autenticado'], 401);
        }
    }
    
    protected function jsonResponse($data, $code = 200)
    {
        return response()->json($data, $code, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
