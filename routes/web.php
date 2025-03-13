<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\OpenAIController;
use Illuminate\Support\Facades\Route;

// Rutas existentes
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('register', [AuthController::class, 'register']);
Route::get('adm', fn() => view('adm'))->middleware('auth');
Route::get('usuario', fn() => view('usuario'))->middleware('auth');

// Rutas existentes movidas de api.php
Route::middleware('auth')->group(function () {
    Route::post('/xai', [ApiController::class, 'sendToXai']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/update', [UserController::class, 'update']);
    Route::post('/users/delete', [UserController::class, 'destroy']);
    Route::get('/questions', [QuestionController::class, 'index']);
    Route::post('/questions/store', [QuestionController::class, 'store']);
    Route::post('/questions/update', [QuestionController::class, 'update']);
    Route::post('/questions/delete', [QuestionController::class, 'destroy']);
});

// Nueva ruta para el mensaje de bienvenida
Route::get('/welcome-message', [OpenAIController::class, 'generateWelcomeMessage'])->middleware('auth')->name('welcome.message');