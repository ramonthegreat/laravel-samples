<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

Route::middleware(['auth:sanctum', 'ability:access-api'])->group(function () {
    Route::delete('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);

    Route::get('/auth-user', [\App\Http\Controllers\UserController::class, 'currentUser']);
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'userList']);
    Route::get('/user/{user}', [\App\Http\Controllers\UserController::class, 'user']);
    Route::post('/user/update-profile', [\App\Http\Controllers\UserController::class, 'updateProfile']);

    Route::prefix('user-pokemon')->group(function (){
        Route::post('/add', [\App\Http\Controllers\UserPokemonController::class, 'addPokemon']);
        Route::post('/remove', [\App\Http\Controllers\UserPokemonController::class, 'removePokemon']);
    });
});

Route::middleware(['auth:sanctum', 'ability:issue-access-token'])->group(function () {
    Route::post('/refresh-token', [\App\Http\Controllers\AuthController::class, 'refreshToken']);
});
//Logout


