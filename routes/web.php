<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(BoardController::class)->prefix('/board')->group(function () {
    Route::get('/{board}', 'show');
});

Route::prefix('/account')->group(function () {
    Route::get('/login', [LoginController::class, 'index']);
    Route::get('/create', [UserController::class, 'index']);
});
