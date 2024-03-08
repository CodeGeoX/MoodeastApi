<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterAuthRequest;
use App\Models\User;
use App\Models\CommunityCard;
use Illuminate\Support\Facades\Auth;
use App\Models\EmotionalCard;


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
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'avatar' => '001.png', 
        ]);

        $token = $user->createToken('appToken')->plainTextToken;

        return response()->json([
            'status' => 'ok',
            'token' => $token,
            'name' => $user->name,
            'user_id' => $user->id, 
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
            'avatar' => $user->avatar, 
            'user_id' => $user->id, 
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

    public function createCommunityCard(Request $request)
{
    $request->validate([
        'nombre' => 'required',
        'perfil' => 'required',
        'userResponse' => 'required',
    ]);
    
    try {
        $user = $request->user(); 
        $communityCard = CommunityCard::create([
            'nombre' => $request->nombre,
            'perfil' => $request->perfil,
            'userResponse' => $request->userResponse,
            'user_id' => $user->id, 
        ]);

        return response()->json([
            'status' => 'ok',
            'message' => 'Tarjeta de comunidad creada exitosamente.',
            'communityCard' => $communityCard,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error al crear la tarjeta de comunidad.',
            'error' => $e->getMessage(),
        ], 500);
    }
}



    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required',
            ]);
            
            $user = $request->user();
            $user->password = bcrypt($request->password);
            $user->save();
    
            return response()->json([
                'status' => 'ok',
                'message' => 'Contraseña actualizada exitosamente.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar la contraseña.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    
    public function updateAvatar(Request $request)
{
    try {
        $request->validate([
            'avatar' => 'required', 
        ]);

        $user = $request->user();
        $user->avatar = $request->avatar;
        $user->save();

        return response()->json([
            'status' => 'ok',
            'message' => 'Avatar de usuario actualizado exitosamente.',
            'avatar' => $user->avatar, 
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error al actualizar el avatar del usuario.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


public function deleteCommunityCard($id)
{
    try {
        $user = Auth::user();
        $communityCard = CommunityCard::where('id', $id)->where('user_id', $user->id)->first();

        if ($communityCard) {
            $communityCard->delete();
            return response()->json(['status' => 'ok', 'message' => 'Tarjeta de comunidad eliminada exitosamente.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Tarjeta de comunidad no encontrada para este usuario.'], 404);
        }
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Error al eliminar la tarjeta de comunidad.', 'error' => $e->getMessage()], 500);
    }
}
public function updateCommunityCard(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required',
        'perfil' => 'required',
        'userResponse' => 'required',
    ]);

    try {
        $user = $request->user();
        $communityCard = CommunityCard::where('id', $id)->where('user_id', $user->id)->first(); 

        if ($communityCard) {
            $communityCard->update([
                'nombre' => $request->nombre,
                'perfil' => $request->perfil,
                'userResponse' => $request->userResponse,
            ]);

            return response()->json([
                'status' => 'ok',
                'message' => 'Tarjeta de comunidad actualizada exitosamente.',
                'communityCard' => $communityCard,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Tarjeta de comunidad no encontrada para este usuario.',
            ], 404);
        }
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error al actualizar la tarjeta de comunidad.',
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

    public function storeEmotionalCard(Request $request)
{
    $request->validate([
        'emotional_state' => 'required',
        'emotions' => 'nullable|array', // Añadir validación para el campo emotions
        'emotions.*' => 'string', // Asegurar que cada emoción sea una cadena de texto
    ]);

    try {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Usuario no autenticado',
            ], 401);
        }

        $emotionalCard = EmotionalCard::create([
            'emotional_state' => $request->emotional_state,
            'emotions' => $request->emotions, 
            'user_id' => $user->id,
        ]);

        return response()->json([
            'status' => 'ok',
            'message' => 'Tarjeta emocional creada exitosamente.',
            'emotionalCardId' => $emotionalCard->id,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error al crear la tarjeta emocional.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function getEmotionalCards(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'Usuario no autenticado',
        ], 401);
    }

    // Asumiendo que tienes una relación de uno a muchos desde User a EmotionalCard
    $emotionalCards = $user->emotionalCards()->get();

    // Transforma las tarjetas emocionales si es necesario para incluir datos adicionales
    $transformedCards = $emotionalCards->map(function ($card) {
        return [
            'id' => $card->id,
            'emotional_state' => $card->emotional_state,
            'emotions' => $card->emotions, // Asegúrate de que esto devuelva una lista si es un campo de texto/array
            'date' => $card->created_at->toDateString(), // O cualquier campo que indique la fecha de la tarjeta
            // Puedes añadir más campos aquí según sea necesario
        ];
    });

    return response()->json([
        'status' => 'ok',
        'emotionalCards' => $transformedCards,
    ], 200);
}

public function deleteEmotionalCard(Request $request) {
    // Valida los datos de la solicitud
    $request->validate([
        'emotional_card_id' => 'required|exists:emotional_cards,id',
    ]);

    try {
        // Encuentra la tarjeta emocional por su ID
        $emotionalCard = EmotionalCard::find($request->emotional_card_id);

        // Verifica si la tarjeta existe
        if ($emotionalCard) {
            // Elimina la tarjeta emocional
            $emotionalCard->delete();

            // Retorna una respuesta exitosa
            return response()->json(['message' => 'Tarjeta emocional eliminada correctamente'], 200);
        } else {
            // Retorna un mensaje de error si la tarjeta no existe
            return response()->json(['error' => 'La tarjeta emocional no fue encontrada'], 404);
        }
    } catch (\Exception $e) {
        // Retorna un mensaje de error en caso de una excepción
        return response()->json(['error' => 'Error al eliminar la tarjeta emocional: ' . $e->getMessage()], 500);
    }
}

public function updateEmotionalCard(Request $request, $id)
{
    $request->validate([
        'emotional_state' => 'required',
        'emotions' => 'nullable|array',
        'emotions.*' => 'string',
    ]);

    try {
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Usuario no autenticado',
            ], 401);
        }

        // Busca la tarjeta emocional por su ID y verifica si pertenece al usuario
        $emotionalCard = EmotionalCard::where('id', $id)->where('user_id', $user->id)->first();

        if (!$emotionalCard) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tarjeta emocional no encontrada o acceso denegado',
            ], 404);
        }

        // Actualiza la tarjeta emocional con los nuevos datos
        $emotionalCard->update([
            'emotional_state' => $request->emotional_state,
            'emotions' => $request->emotions,
        ]);

        return response()->json([
            'status' => 'ok',
            'message' => 'Tarjeta emocional actualizada exitosamente.',
            'emotionalCard' => $emotionalCard,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error al actualizar la tarjeta emocional.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    protected function jsonResponse($data, $code = 200)
    {
        return response()->json($data, $code, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
