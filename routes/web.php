<?php

use App\Http\Controllers\RenderController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RenderController::class, 'index']);
Route::get('/tasks', [RenderController::class, 'dashboard']);
Route::get('/register', [RenderController::class, 'register']);



