<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="JobConnect - Platform pencarian kerja dan rekrutmen terbaik">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'JobConnect')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('admin.jobs.index') }}">
                <i class="bi bi-briefcase me-2"></i>
                <span>JobConnect</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Left Side Nav -->
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(auth()->user()->role === 'user')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.jobs.index') }}">
                                    <i class="bi bi-search me-1"></i> Cari Lowongan
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->role === 'company')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('company.jobs.create') }}">
                                    <i class="bi bi-plus-circle me-1"></i> Buat Lowongan
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.jobs.index') }}">
                                <i class="bi bi-search me-1"></i> Cari Lowongan
                            </a>
                        </li>
                    @endauth
                </ul>

                <!-- Right Side Nav -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(isset($unreadNotificationsCount))
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-bell"></i>
                                @if($unreadNotificationsCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $unreadNotificationsCount }}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-2" style="width: 350px;">
                                <li>
                                    <h6 class="dropdown-header">Notifikasi</h6>
                                </li>
                                @forelse($notifications as $notification)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center py-2 {{ $notification->unread() ? 'bg-light' : '' }}"
                                           href="{{ $notification->data['url'] ?? '#' }}">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="bi bi-{{ $notification->data['icon'] ?? 'bell' }} text-{{ $notification->data['color'] ?? 'primary' }}"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between">
                                                    <h6 class="mb-0">{{ $notification->data['title'] }}</h6>
                                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                </div>
                                                <p class="mb-0 text-muted small">{{ Str::limit($notification->data['message'], 40) }}</p>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li class="text-center py-3 text-muted">
                                        Tidak ada notifikasi
                                    </li>
                                @endforelse
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-center" href="#">
                                        Lihat Semua Notifikasi
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        <!-- User Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="avatar-sm me-2">
                                    <span class="avatar-title bg-light text-dark rounded-circle">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="d-none d-lg-inline">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <h6 class="dropdown-header">Akun Saya</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-person me-2"></i> Profil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ 
                                        auth()->user()->role === 'admin' ? route('admin.dashboard') : 
                                        (auth()->user()->role === 'company' ? route('company.dashboard') : route('user.dashboard')) 
                                    }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-gear me-2"></i> Pengaturan
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light ms-2" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i> Daftar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1 py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-briefcase me-2"></i> JobConnect
                    </h5>
                    <p class="small">
                        Platform pencarian kerja dan rekrutmen terbaik untuk menghubungkan perusahaan dengan talenta terbaik.
                    </p>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h6 class="fw-bold">Untuk Pencari Kerja</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('admin.jobs.index') }}" class="text-white-50">Cari Lowongan</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50">Tips Karir</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50">Buat Resume</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h6 class="fw-bold">Untuk Perusahaan</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('register') }}?role=company" class="text-white-50">Daftar Perusahaan</a></li>
                        <li class="mb-2"><a href="{{ route('company.jobs.create') }}" class="text-white-50">Pasang Lowongan</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50">Solusi Rekrutmen</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold">Hubungi Kami</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i> hello@jobconnect.id</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i> (021) 1234-5678</li>
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Jakarta, Indonesia</li>
                    </ul>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="text-white"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-twitter-x fs-5"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-linkedin fs-5"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small">
                <div class="mb-3 mb-md-0">
                    &copy; {{ date('Y') }} JobConnect. All rights reserved.
                </div>
                <div>
                    <a href="#" class="text-white-50 me-3">Kebijakan Privasi</a>
                    <a href="#" class="text-white-50 me-3">Syarat & Ketentuan</a>
                    <a href="#" class="text-white-50">Panduan</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>
