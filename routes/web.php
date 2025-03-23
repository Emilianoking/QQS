<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\CarreraController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortafolioController;
use App\Http\Controllers\UserResponseController;
use App\Http\Controllers\BlogQuestionController;
use App\Http\Controllers\UserLatestResponsesController;

// Rutas públicas (sin autenticación)
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('register', [AuthController::class, 'register']);
Route::get('adm', fn() => view('adm'))->middleware('auth');
Route::get('usuario', fn() => view('usuario'))->middleware('auth');


// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Rutas existentes
    Route::get('/latest-responses', [UserLatestResponsesController::class, 'getLatestResponses'])->middleware('auth');
    Route::post('/xai', [ApiController::class, 'sendToXai']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/update', [UserController::class, 'update']);
    Route::post('/users/delete', [UserController::class, 'destroy']);
    Route::get('/questions', [QuestionController::class, 'index']);
    Route::post('/questions/store', [QuestionController::class, 'store']);
    Route::post('/questions/update', [QuestionController::class, 'update']);
    Route::post('/questions/delete', [QuestionController::class, 'destroy']);
    Route::get('/welcome-message', [OpenAIController::class, 'generateWelcomeMessage'])->name('welcome.message');
    Route::get('/portafolio', [PortafolioController::class, 'index']);
    Route::get('/carreras', [CarreraController::class, 'index']);
    Route::post('/carreras/store', [CarreraController::class, 'store']);
    Route::post('/carreras/update', [CarreraController::class, 'update']);
    Route::post('/user-responses', [UserResponseController::class, 'store'])->middleware('auth');
    Route::get('/blog-questions', [BlogQuestionController::class, 'getQuestions'])->middleware('auth');
    Route::post('/carreras/delete', [CarreraController::class, 'destroy']);
});