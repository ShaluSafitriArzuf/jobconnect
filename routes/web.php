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
// ROUTE PUBLIK
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

    // ✅ Ini menampilkan landing.blade.php kalau belum login
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
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [UserController::class, 'adminDashboard'])->name('admin.dashboard');

    Route::resource('users', UserController::class)->names('admin.users');

    Route::resource('companies', CompanyController::class)
        ->except(['create', 'store'])
        ->names('admin.companies');

    Route::resource('categories', CategoryController::class)->names('admin.categories');

    Route::get('/jobs', [JobController::class, 'adminIndex'])->name('admin.jobs.index');
    Route::get('/jobs/create', [JobController::class, 'create'])->name('admin.jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('admin.jobs.store');
    Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('admin.jobs.edit');
    Route::put('/jobs/{id}', [JobController::class, 'update'])->name('admin.jobs.update');
    Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('admin.jobs.destroy');

    Route::get('/applications', [ApplicationController::class, 'index'])->name('admin.applications.index');
});


// ===================
// ROUTE COMPANY
// ===================
Route::middleware(['auth', 'role:company'])->prefix('company')->group(function () {

    // Cek apakah sudah punya profil
    Route::get('/profile/create', [CompanyController::class, 'create'])->name('company.profile.create');
    Route::post('/profile', [CompanyController::class, 'store'])->name('company.profile.store');

    Route::get('/dashboard', [CompanyController::class, 'dashboard'])->name('company.dashboard');
    Route::get('/profile', [CompanyController::class, 'editProfile'])->name('company.profile');
    Route::put('/profile', [CompanyController::class, 'updateProfile'])->name('company.profile.update');

    Route::get('/jobs', [JobController::class, 'companyIndex'])->name('company.jobs.index');
    Route::get('/jobs/create', [JobController::class, 'create'])->name('company.jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('company.jobs.store');
    Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('company.jobs.edit');
    Route::put('/jobs/{id}', [JobController::class, 'update'])->name('company.jobs.update');
    Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('company.jobs.destroy');
    Route::get('/jobs/{id}', [JobController::class, 'show'])->name('company.jobs.show');
    

    Route::get('/jobs/{id}/applicants', [ApplicationController::class, 'applicants'])->name('applications.applicants');
    Route::put('/applications/{id}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    Route::get('/company/applications', [ApplicationController::class, 'index'])->name('company.applications.index');

});


// ===================
// ROUTE USER
// ===================
Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/applications', [ApplicationController::class, 'userApplications'])->name('applications.index');
    Route::get('/applications/create/{jobId}', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications/{job}', [ApplicationController::class, 'store'])->name('applications.store');
    
});
