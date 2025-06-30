@extends('layouts.app')

@section('content')
    <h2>Edit Lowongan Kerja</h2>

    @if ($errors->any())
        <div style="color: red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jobs.update', $job->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Judul:</label><br>
        <input type="text" name="title" value="{{ old('title', $job->title) }}"><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="description">{{ old('description', $job->description) }}</textarea><br><br>

        <label>Lokasi:</label><br>
        <input type="text" name="location" value="{{ old('location', $job->location) }}"><br><br>

        <label>Jenis Pekerjaan:</label><br>
        <select name="job_type">
            <option value="Full-Time" {{ $job->job_type == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
            <option value="Part-Time" {{ $job->job_type == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
            <option value="Internship" {{ $job->job_type == 'Internship' ? 'selected' : '' }}>Internship</option>
        </select><br><br>

        <label>Deadline:</label><br>
        <input type="date" name="deadline" value="{{ old('deadline', $job->deadline->format('Y-m-d')) }}"><br><br>

        <label>Kategori:</label><br>
        <select name="category_id">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $job->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select><br><br>

        <button type="submit">Update</button>
    </form>
@endsection
