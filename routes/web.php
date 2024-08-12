<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::controller(BoardController::class)->prefix('/board')->group(function () {
    Route::get('/{board}', 'show');
});

Route::get('/login', [LoginController::class, 'index']);
