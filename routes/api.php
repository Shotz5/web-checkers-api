<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PieceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(BoardController::class)->prefix('/board')->group(function () {
    Route::get('/create', 'create');
});

Route::controller(PieceController::class)->prefix('/piece')->group(function () {
    Route::patch('/{piece}', 'update');
});

Route::prefix('/account')->group(function () {
    Route::post('/login', [LoginController::class, 'create']);
    Route::post('/create', [UserController::class, 'create']);
});
