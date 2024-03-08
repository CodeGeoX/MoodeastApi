<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommunityCardController;
use App\Http\Controllers\FraseDiariaController;
use App\Http\Controllers\EmotionalCardController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/fraseDelDia', [FraseDiariaController::class, 'getFraseDiaria']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::put('/emotional-cards/{id}', [AuthController::class, 'updateEmotionalCard']);
    Route::delete('/delete-emotional-card', [AuthController::class, 'deleteEmotionalCard']);
    Route::post('/emotional-cards', [AuthController::class, 'storeEmotionalCard']);
    Route::put('/update-emotional-card', [AuthController::class, 'updateEmotionalCard']);
    Route::get('/emotional-cards', [AuthController::class, 'getEmotionalCards']);
    Route::post('/delete-emotional-card', [AuthController::class, 'deleteEmotionalCard']);
    Route::put('/community-cards/{id}', [AuthController::class, 'updateCommunityCard']);
    Route::delete('/community-cards/{id}', [AuthController::class, 'deleteCommunityCard']);
    Route::put('/update-name', [AuthController::class, 'updateName']); 
    Route::put('/update-password', [AuthController::class, 'updatePassword']);
    Route::put('/update-avatar', [AuthController::class, 'updateAvatar']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'getAuthUser']);
    Route::get('/api/get-user-info', [AuthController::class, 'getUserInfo']);
    Route::post('/create-community-card', [AuthController::class, 'createCommunityCard']);
    Route::get('/community-cards', [CommunityCardController::class, 'index']);
});


