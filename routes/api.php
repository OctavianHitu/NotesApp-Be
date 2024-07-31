<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/note/{id}', [NoteController::class, 'index'])->middleware('auth:sanctum');
Route::post('/note', [NoteController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/noterr', [NoteController::class, 'notePatch'])->middleware('auth:sanctum');
Route::delete('/note/{id}', [NoteController::class, 'destroy'])->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
