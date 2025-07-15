<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    JobController,
    CategoryController,
    CompanyController,
    ApplicationController,
    UserController
};

// ===================
// ROUTE PUBLIK (Tanpa Auth)
// ===================
Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'company' => redirect()->route('company.dashboard'),
            'user' => redirect()->route('user.dashboard'),
            default => redirect()->route('login'),
        };
    }
    return view('landing');
})->name('home');

Route::controller(JobController::class)->group(function () {
    Route::get('/jobs', 'publicIndex')->name('jobs.index');
    Route::get('/jobs/{id}', 'show')->where('id', '[0-9]+')->name('jobs.show');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'formLogin')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'formRegister')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'destroy')->name('logout');
});


// ===================
// ROUTE ADMIN
// ===================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'adminDashboard'])->name('dashboard');

    Route::resource('users', UserController::class);

    Route::resource('companies', CompanyController::class)->except(['create', 'store']);

    Route::resource('categories', CategoryController::class);

    Route::get('/jobs', [JobController::class, 'adminIndex'])->name('jobs.index');
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{id}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');

    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
});


// ===================
// ROUTE COMPANY
// ===================
Route::middleware(['auth', 'role:company'])->prefix('company')->name('company.')->group(function () {
    Route::get('/dashboard', [CompanyController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [CompanyController::class, 'editProfile'])->name('profile.edit');
    Route::get('/profile/create', [CompanyController::class, 'create'])->name('profile.create');
    Route::post('/profile', [CompanyController::class, 'store'])->name('profile.store');
    Route::put('/profile', [CompanyController::class, 'updateProfile'])->name('profile.update');

    Route::get('/jobs', [JobController::class, 'companyIndex'])->name('jobs.index');
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{id}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');
    Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');

    Route::get('/jobs/{id}/applicants', [ApplicationController::class, 'applicants'])->name('applications.applicants');
    Route::put('/applications/{id}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
});


// ===================
// ROUTE USER
// ===================
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'userDashboard'])->name('dashboard');
    Route::get('/applications', [ApplicationController::class, 'userApplications'])->name('applications.index');
    Route::get('/applications/create/{jobId}', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications/{job}', [ApplicationController::class, 'store'])->name('applications.store');
});
