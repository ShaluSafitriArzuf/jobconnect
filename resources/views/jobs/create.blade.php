@extends('layouts.app')

@section('content')
    <h2>Tambah Lowongan Kerja</h2>

    @if ($errors->any())
        <div style="color: red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jobs.store') }}" method="POST">
        @csrf

        <label>Judul:</label><br>
        <input type="text" name="title" value="{{ old('title') }}"><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="description">{{ old('description') }}</textarea><br><br>

        <label>Lokasi:</label><br>
        <input type="text" name="location" value="{{ old('location') }}"><br><br>

        <label>Jenis Pekerjaan:</label><br>
        <select name="job_type">
            <option value="Full-Time">Full-Time</option>
            <option value="Part-Time">Part-Time</option>
            <option value="Internship">Internship</option>
        </select><br><br>

        <label>Deadline:</label><br>
        <input type="date" name="deadline" value="{{ old('deadline') }}"><br><br>

        <label>Kategori:</label><br>
        <select name="category_id">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select><br><br>

        <button type="submit">Simpan</button>
    </form>
@endsection
