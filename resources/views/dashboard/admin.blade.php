@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h2 class="fw-bold">Dashboard Admin</h2>
    <p>Selamat datang, {{ auth()->user()->name }}! 👑</p>
    <p>Kelola kategori dan pantau data di sini.</p>
@endsection
