<?php
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:web')->group(function () {
    Route::post('/xai', [ApiController::class, 'sendToXai']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/update', [UserController::class, 'update']);
    Route::post('/users/delete', [UserController::class, 'destroy']);
    Route::get('/questions', [QuestionController::class, 'index']);
    Route::post('/questions/store', [QuestionController::class, 'store']);
    Route::post('/questions/update', [QuestionController::class, 'update']);
    Route::post('/questions/delete', [QuestionController::class, 'destroy']);
});