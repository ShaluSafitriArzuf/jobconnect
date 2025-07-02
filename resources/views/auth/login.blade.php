@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container" style="max-width: 400px; margin: auto; padding-top: 50px;">
    <h2 class="text-center mb-4">Login</h2>

    {{-- Tampilkan error kalau login gagal --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>
@endsection
