<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\PortafolioController;
use App\Http\Controllers\UserResponseController;
use App\Http\Controllers\BlogQuestionController;
use App\Http\Controllers\UserLatestResponsesController;
use App\Http\Controllers\ResultadoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecommendedCareersController;
use App\Http\Controllers\WelcomeMessageController;

// Rutas públicas (sin autenticación)
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('register', [AuthController::class, 'register']);
Route::get('adm', fn() => view('adm'))->middleware('auth');
Route::get('usuario', fn() => view('usuario'))->middleware('auth');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // Usuarios
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/update/{id}', [UserController::class, 'update']);
    Route::delete('/users/delete/{id}', [UserController::class, 'destroy']);

    // Preguntas
    Route::get('/questions', [QuestionController::class, 'index']);
    Route::post('/questions/store', [QuestionController::class, 'store']);
    Route::post('/questions/update/{id}', [QuestionController::class, 'update']);
    Route::delete('/questions/delete/{id}', [QuestionController::class, 'destroy']);

    // Carreras
    Route::get('/carreras', [CarreraController::class, 'index']);
    Route::post('/carreras/store', [CarreraController::class, 'store']);
    Route::post('/carreras/update/{id}', [CarreraController::class, 'update']);
    Route::delete('/carreras/delete/{id}', [CarreraController::class, 'destroy']);

    // Resultados (Rangos)
    Route::get('/resultados', [ResultadoController::class, 'index']);
    Route::post('/resultados/store', [ResultadoController::class, 'store']);
    Route::post('/resultados/update/{id}', [ResultadoController::class, 'update']);
    Route::delete('/resultados/delete/{id}', [ResultadoController::class, 'destroy']);

    // Otras rutas
    Route::post('/xai', [ApiController::class, 'sendToXai']);
    Route::get('/portafolio', [PortafolioController::class, 'index']);
    Route::post('/user-responses', [UserResponseController::class, 'store']);
    Route::get('/blog-questions', [BlogQuestionController::class, 'getQuestions']);
    Route::get('/latest-responses', [UserLatestResponsesController::class, 'getLatestResponses']);
    Route::get('/welcome-message', [WelcomeMessageController::class, 'getWelcomeMessage'])->middleware('auth');
    Route::get('/recommended-careers', [RecommendedCareersController::class, 'getRecommendedCareers'])->middleware('auth');
});