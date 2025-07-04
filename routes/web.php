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
use App\Http\Middleware\RoleMiddleware;

// ===================
// ROUTE PUBLIK UNTUK LOWONGAN
// ===================
Route::controller(JobController::class)->group(function () {
    Route::get('/jobs', 'index')->name('jobs.index');
    Route::get('/jobs/{id}', 'show')->where('id', '[0-9]+')->name('jobs.show');
});

// ===================
// ROUTE AUTENTIKASI (PUBLIK)
// ===================
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'formLogin')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'formRegister')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'destroy')->name('logout');
});

// ===================
// ROUTE UTAMA (HOME)
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
    return redirect()->route('jobs.index');
})->name('home');

// ===================
// ROUTE BERDASARKAN ROLE (DENGAN AUTH)
// ===================
Route::middleware(['auth'])->group(function () {
    // ROUTE UNTUK ADMIN
    Route::middleware([RoleMiddleware::class . ':admin'])->prefix('admin')->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [UserController::class, 'adminDashboard'])->name('admin.dashboard');

        // Manajemen User
        Route::resource('users', UserController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy'
        ]);

        // Manajemen Perusahaan
        Route::resource('companies', CompanyController::class)->names([
            'index' => 'admin.companies.index',
            'create' => 'admin.companies.create',
            'store' => 'admin.companies.store',
            'show' => 'admin.companies.show',
            'edit' => 'admin.companies.edit',
            'update' => 'admin.companies.update',
            'destroy' => 'admin.companies.destroy'
        ]);

        // Manajemen Kategori
        Route::resource('categories', CategoryController::class)->names([
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'show' => 'admin.categories.show',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy'
        ]);

        // Manajemen Lowongan
        Route::resource('jobs', JobController::class)->except(['show'])->names([
            'index' => 'admin.jobs.index',
            'create' => 'admin.jobs.create',
            'store' => 'admin.jobs.store',
            'edit' => 'admin.jobs.edit',
            'update' => 'admin.jobs.update',
            'destroy' => 'admin.jobs.destroy'
        ]);
        Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
            Route::resource('users', UserController::class)->names([
                'index' => 'admin.users.index',
                'create' => 'admin.users.create',
                'store' => 'admin.users.store',
                'show' => 'admin.users.show',
                'edit' => 'admin.users.edit',
                'update' => 'admin.users.update',
                'destroy' => 'admin.users.destroy'
            ]);
        });

        // Manajemen Lamaran
        Route::get('/applications', [ApplicationController::class, 'index'])->name('admin.applications.index');
    });

    // ROUTE UNTUK PERUSAHAAN
    Route::middleware([RoleMiddleware::class . ':company'])->prefix('company')->group(function () {
        // Dashboard Perusahaan
        Route::get('/dashboard', [CompanyController::class, 'dashboard'])->name('company.dashboard');

        // Manajemen Lowongan
        Route::resource('jobs', JobController::class)->except(['index', 'show']);

        // Manajemen Pelamar
        Route::get('/jobs/{id}/applicants', [ApplicationController::class, 'applicants'])
            ->name('company.applicants');
        Route::put('/applications/{id}/status', [ApplicationController::class, 'updateStatus'])
            ->name('company.applications.updateStatus');

        // Profil Perusahaan
        Route::get('/profile', [CompanyController::class, 'edit'])->name('company.profile');
        Route::put('/profile', [CompanyController::class, 'update'])->name('company.profile.update');
    });

    // ROUTE UNTUK USER/PENCARI KERJA
    Route::middleware([RoleMiddleware::class . ':user'])->prefix('user')->group(function () {
        // Dashboard User
        Route::get('/dashboard', [UserController::class, 'userDashboard'])->name('user.dashboard');

        // Manajemen Lamaran
        Route::get('/applications', [ApplicationController::class, 'userApplications'])
            ->name('user.applications.index');
        Route::get('/applications/create/{jobId}', [ApplicationController::class, 'create'])
            ->name('user.applications.create');
        Route::post('/applications/store/{jobId}', [ApplicationController::class, 'store'])
            ->name('user.applications.store');
    });
});