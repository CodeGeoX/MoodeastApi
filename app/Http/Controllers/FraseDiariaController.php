<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FraseDiaria;

class FraseDiariaController extends Controller
{
    public function getFraseDiaria()
{
    $dayOfYear = now()->dayOfYear;
    $totalFrases = FraseDiaria::count();

    $fraseIndex = ($dayOfYear % $totalFrases) + 1;

    $fraseDiaria = FraseDiaria::find($fraseIndex);

    if ($fraseDiaria) {
        return response()->json(['frase' => $fraseDiaria->frase]);
    } else {
        return response()->json(['error' => 'Frase no encontrada'], 404);
    }
}

}
