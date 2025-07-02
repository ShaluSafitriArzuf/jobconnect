@extends('layouts.app')

@section('title', 'Dashboard Perusahaan')

@section('content')
    <h2 class="fw-bold">Dashboard Perusahaan</h2>
    <p>Halo, {{ auth()->user()->name }}! 🏢</p>
    <p>Kamu bisa mengelola lowongan kerja dan melihat pelamar di sini.</p>
@endsection
