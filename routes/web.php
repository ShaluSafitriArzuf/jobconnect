<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', function () {
    return 'Selamat datang Admin!';
})->middleware([RoleMiddleware::class . ':admin']);

Route::get('/company/dashboard', function () {
    return 'Selamat datang Perusahaan!';
})->middleware([RoleMiddleware::class . ':company']);

Route::get('/user/dashboard', function () {
    return 'Selamat datang User!';
})->middleware([RoleMiddleware::class . ':user']);