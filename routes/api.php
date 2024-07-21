<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\PieceController;
use Illuminate\Support\Facades\Route;

Route::controller(BoardController::class)->prefix('/board')->group(function () {
    Route::get('/{board}', 'index');
    Route::get('/create', 'create');
});

Route::controller(PieceController::class)->prefix('/piece')->group(function () {
    Route::patch('/{piece}', 'update');
});
