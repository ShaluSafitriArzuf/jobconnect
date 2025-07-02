<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;

// ===================
// AUTH ROUTES
// ===================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'formRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

// ===================
// PUBLIC JOB ROUTES
// ===================
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');

// ===================
// DASHBOARD PER ROLE
// ===================
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->get('/admin/dashboard', function () {
    return view('dashboard.admin');
})->name('dashboard.admin');

Route::middleware(['auth', RoleMiddleware::class . ':company'])->get('/company/dashboard', function () {
    return view('dashboard.company');
})->name('dashboard.company');

Route::middleware(['auth', RoleMiddleware::class . ':user'])->get('/user/dashboard', function () {
    return view('dashboard.user');
})->name('dashboard.user');

// ===================
// JOB CRUD + PELAMAR (Hanya untuk company)
// ===================
Route::middleware(['auth', RoleMiddleware::class . ':company'])->group(function () {
    Route::resource('jobs', JobController::class)->except(['index', 'show']);
    
    Route::get('/jobs/{id}/applicants', [ApplicationController::class, 'applicants'])->name('applications.applicants');
    Route::put('/applications/{id}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
});

// ===================
// CATEGORY CRUD (Hanya untuk admin)
// ===================
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Kelola user
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

// ===================
// COMPANY CRUD (Hanya untuk company)
// ===================
Route::middleware(['auth', RoleMiddleware::class . ':company'])->group(function () {
    Route::resource('companies', CompanyController::class)->except(['show']);
});

// ===================
// APPLICATION ROUTES (Hanya untuk user)
// ===================
Route::middleware(['auth', RoleMiddleware::class . ':user'])->group(function () {
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/create/{jobId}', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications/store/{jobId}', [ApplicationController::class, 'store'])->name('applications.store');
});
