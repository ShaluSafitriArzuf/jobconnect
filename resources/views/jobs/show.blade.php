@extends('layouts.app')

@section('content')
    <h2>Detail Lowongan Kerja</h2>

    @php
        use Carbon\Carbon;
    @endphp

    <div style="border: 1px solid #ccc; padding: 20px; width: 60%;">
        <h3>{{ $job->title }}</h3>
        <p><strong>Perusahaan:</strong> {{ $job->company->name ?? '-' }}</p>
        <p><strong>Lokasi:</strong> {{ $job->location }}</p>
        <p><strong>Kategori:</strong> {{ $job->category->name ?? '-' }}</p>
        <p><strong>Jenis Pekerjaan:</strong> {{ $job->job_type }}</p>
        <p><strong>Deadline:</strong> {{ Carbon::parse($job->deadline)->format('d M Y') }}</p>
        <p><strong>Deskripsi:</strong></p>
        <p>{{ $job->description }}</p>
    </div>

    <br>
    <a href="{{ route('jobs.index') }}">⬅️ Kembali ke Daftar</a>
@endsection
