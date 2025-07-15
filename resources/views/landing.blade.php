@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<style>
    .hero {
        background: url("{{ asset('storage/landing.jpg') }}") center/cover no-repeat;
        min-height: 100vh;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
    }

    .hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: bold;
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 30px;
    }

    .btn-custom {
        padding: 0.75rem 2rem;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 50px;
    }
</style>

<div class="hero">
    <div class="hero-content">
        <h1>Temukan Lowongan Pekerjaan Terbaik untukmu</h1>
        <p>Gabung bersama kami dan akses ratusan peluang kerja dari berbagai bidang & perusahaan.</p>
        <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-custom">
            <i class="bi bi-rocket-takeoff me-2"></i> Mulai Cari Lowongan
        </a>
    </div>
</div>
@endsection
