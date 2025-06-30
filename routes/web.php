<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CategoryController;

use App\Http\Middleware\RoleMiddleware;

// ===================
// AUTH
// ===================
Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===================
// DASHBOARD PER ROLE
// ===================
Route::get('/admin/dashboard', function () {
    return 'Selamat datang Admin!';
})->middleware([RoleMiddleware::class . ':admin']);

Route::get('/company/dashboard', function () {
    return 'Selamat datang Perusahaan!';
})->middleware([RoleMiddleware::class . ':company']);

Route::get('/user/dashboard', function () {
    return 'Selamat datang User!';
})->middleware([RoleMiddleware::class . ':user']);

// ===================
// JOB CRUD
// ===================
Route::middleware('auth')->group(function () {

    // Semua role bisa lihat daftar & detail
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');

    // Hanya untuk role 'company'
    Route::middleware(RoleMiddleware::class . ':company')->group(function () {
        Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{id}', [JobController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('jobs.destroy')->middleware(RoleMiddleware::class . ':company');
    });
});
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});
