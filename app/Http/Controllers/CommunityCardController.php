<?php

namespace App\Http\Controllers;

use App\Models\CommunityCard;
use Illuminate\Http\Request;
use Carbon\Carbon;
class CommunityCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    try {
        $user = $request->user();

        // Obtener la última tarjeta de comunidad creada por el usuario en las últimas 24 horas
        $lastCommunityCard = CommunityCard::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->latest()
            ->first();

        // Obtener todas las tarjetas de comunidad que no sean del usuario y que hayan sido creadas en las últimas 24 horas
        $recentCommunityCards = CommunityCard::where('user_id', '!=', $user->id)
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->where('id', '!=', optional($lastCommunityCard)->id) // Excluir la última tarjeta creada por el usuario
            ->get();

        // Agregar la última tarjeta del usuario a la parte superior de la lista
        if ($lastCommunityCard) {
            $communityCards = collect([$lastCommunityCard])->concat($recentCommunityCards);
        } else {
            $communityCards = $recentCommunityCards;
        }

        return response()->json($communityCards);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error al cargar las tarjetas de comunidad.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

    private function getRecentCommunityCards()
    {
        $currentUser = auth()->user();
        
        // Filtra las tarjetas de comunidad que no pertenezcan al usuario actual y que hayan sido creadas en las últimas 24 horas
        $recentCommunityCards = CommunityCard::where('user_id', '!=', $currentUser->id)
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->get();

        return $recentCommunityCards;
    }
}
