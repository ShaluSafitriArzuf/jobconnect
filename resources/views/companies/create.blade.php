@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Perusahaan</h1>

        @if ($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('companies.store') }}" method="POST">
            @csrf
            <label>Nama:</label>
            <input type="text" name="name" required><br>

            <label>Lokasi:</label>
            <input type="text" name="location" required><br>

            <label>Deskripsi:</label>
            <textarea name="description" required></textarea><br>

            <button type="submit">Simpan</button>
        </form>
    </div>
@endsection
