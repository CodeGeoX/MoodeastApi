<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommunityCardController;
use App\Http\Controllers\FraseDiariaController;

Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/fraseDelDia', [FraseDiariaController::class, 'getFraseDiaria']);


Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::put('/update-name', [AuthController::class, 'updateName']); 
    Route::put('/update-password', [AuthController::class, 'updatePassword']);
    Route::put('/update-avatar', [AuthController::class, 'updateAvatar']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'getAuthUser']);
    Route::get('/api/get-user-info', [AuthController::class, 'getUserInfo']);
    Route::post('/create-community-card', [AuthController::class, 'createCommunityCard']);
    Route::get('/community-cards', [CommunityCardController::class, 'index']);
});


