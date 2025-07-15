@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid px-4 py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="fw-bold text-dark mb-0">
            <i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard Admin
        </h1>
        <div class="dropdown">
            <button class="btn btn-light border rounded-pill shadow-sm" type="button" id="dashboardActions" 
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-gear-fill me-1"></i> Menu
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="dashboardActions">
                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Pengaturan</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Laporan</a></li>
            </ul>
        </div>
    </div>

    {{-- Welcome Card --}}
    <div class="card bg-white border-0 shadow rounded-4 mb-5">
        <div class="card-body p-4 d-flex align-items-center">
            <div class="flex-shrink-0">
                <i class="bi bi-person-check-fill display-4 text-primary"></i>
            </div>
            <div class="flex-grow-1 ms-4">
                <h3 class="fw-bold mb-1 text-primary">Selamat datang, {{ auth()->user()->name }} 👑</h3>
                <p class="text-muted mb-0">Anda login sebagai <strong>Administrator</strong>. Gunakan panel ini untuk mengelola data secara menyeluruh.</p>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="row g-4">
        {{-- Template Card --}}
        @php
            $cards = [
                [
                    'title' => 'Total Pengguna',
                    'value' => $totalUsers ?? 0,
                    'icon' => 'people-fill',
                    'color' => 'success',
                    'route' => route('admin.users.index'),
                ],
                [
                    'title' => 'Total Perusahaan',
                    'value' => $totalCompanies ?? 0,
                    'icon' => 'buildings',
                    'color' => 'info',
                    'route' => route('admin.companies.index'),
                ],
                [
                    'title' => 'Total Lowongan',
                    'value' => $totalJobs ?? 0,
                    'icon' => 'briefcase-fill',
                    'color' => 'warning',
                    'route' => route('admin.jobs.index'),
                ],
                [
                    'title' => 'Total Lamaran',
                    'value' => $totalApplications ?? 0,
                    'icon' => 'file-earmark-text-fill',
                    'color' => 'danger',
                    'route' => route('admin.applications.index'),
                ],
            ];
        @endphp

        @foreach ($cards as $card)
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-lg rounded-4 h-100" style="min-height: 200px;">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-grow-1">
                            <h6 class="text-muted fw-semibold">{{ $card['title'] }}</h6>
                            <h2 class="fw-bold text-{{ $card['color'] }}">{{ $card['value'] }}</h2>
                        </div>
                        <div class="bg-{{ $card['color'] }} bg-opacity-10 p-3 rounded-circle">
                            <i class="bi bi-{{ $card['icon'] }} fs-3 text-{{ $card['color'] }}"></i>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ $card['route'] }}" class="btn btn-sm btn-outline-{{ $card['color'] }} rounded-pill">
                            <i class="bi bi-arrow-right me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
