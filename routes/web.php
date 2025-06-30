<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\JobController;

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


Route::middleware('auth')->group(function () {
    // Halaman untuk semua user (bisa lihat semua job)
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

    // Detail job (semua role boleh lihat)
    Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');

    // Untuk company: create job
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create')->middleware(\App\Http\Middleware\RoleMiddleware::class . ':company');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store')->middleware(\App\Http\Middleware\RoleMiddleware::class . ':company');

    // Edit dan update job (hanya company)
    Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit')->middleware(\App\Http\Middleware\RoleMiddleware::class . ':company');
    Route::put('/jobs/{id}', [JobController::class, 'update'])->name('jobs.update')->middleware(\App\Http\Middleware\RoleMiddleware::class . ':company');

    // Hapus job (company)
    Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('jobs.destroy')->middleware(\App\Http\Middleware\RoleMiddleware::class . ':company');
});
