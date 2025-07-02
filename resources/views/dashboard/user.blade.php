@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
    <h2 class="fw-bold">Dashboard Pengguna</h2>
    <p>Selamat datang, {{ auth()->user()->name }}! 🙋‍♀️</p>
    <p>Cari lowongan yang cocok dan lamar pekerjaan impianmu!</p>
@endsection
