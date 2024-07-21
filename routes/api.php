<?php

use App\Http\Controllers\BoardController;
use Illuminate\Support\Facades\Route;

Route::controller(BoardController::class)->prefix('/board')->group(function () {
    Route::get('/', 'index');
    Route::get('/create', 'create');
    Route::patch('/{board_id}', 'update');
});
