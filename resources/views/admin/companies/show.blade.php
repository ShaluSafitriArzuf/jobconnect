@extends('layouts.app')

@section('title', 'Detail Perusahaan')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-building me-2"></i>Detail Perusahaan
    </h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <!-- Logo -->
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    @if ($company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo Perusahaan" class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                    @else
                        <div class="text-muted"><em>Tidak ada logo</em></div>
                    @endif
                </div>

                <!-- Detail -->
                <div class="col-md-9">
                    <h4 class="fw-bold">{{ $company->name }}</h4>
                    <p class="text-muted">{{ $company->description ?? '-' }}</p>

                    <table class="table table-borderless mt-3">
                        <tr>
                            <th width="160">Email</th>
                            <td>{{ $company->email }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $company->location }}</td>
                        </tr>
                        <tr>
                            <th>Industri</th>
                            <td>{{ $company->industry ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat pada</th>
                            <td>{{ $company->created_at->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ======= LOWONGAN KERJA ======= --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <strong>Lowongan yang Diposting</strong>
        </div>
        <div class="card-body p-0">
            @if($company->jobs->count())
                <ul class="list-group list-group-flush">
                    @foreach($company->jobs as $job)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $job->title }}</strong>
                                <br>
                                <small class="text-muted">{{ $job->location }} - Diposting {{ $job->created_at->diffForHumans() }}</small>
                            </div>
                            {{-- Admin tidak bisa edit job --}}
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted p-3 mb-0">Belum ada lowongan diposting perusahaan ini.</p>
            @endif
        </div>
    </div>

    <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary mt-4">← Kembali ke Daftar Perusahaan</a>
</div>
@endsection
