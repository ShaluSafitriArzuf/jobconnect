@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Perusahaan</h1>

        @if ($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('companies.update', $company->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label>Nama:</label>
            <input type="text" name="name" value="{{ $company->name }}" required><br>

            <label>Lokasi:</label>
            <input type="text" name="location" value="{{ $company->location }}" required><br>

            <label>Deskripsi:</label>
            <textarea name="description" required>{{ $company->description }}</textarea><br>

            <button type="submit">Update</button>
        </form>
    </div>
@endsection
