<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/usuario', fn() => view('usuario'))->middleware('auth');
Route::get('/adm', fn() => view('adm'))->middleware('auth');
// Route::post('/xai', [ApiController::class, 'sendToXai'])->middleware('auth');
Route::post('/xai', [ApiController::class, 'sendToXai'])->middleware('auth');