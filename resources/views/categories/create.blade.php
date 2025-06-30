@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="mb-3">
        <h2>Tambah Kategori Baru</h2>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ups!</strong> Ada masalah dengan inputmu:<br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" name="name" class="form-control" placeholder="Contoh: IT, Keuangan, Desain..." required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
