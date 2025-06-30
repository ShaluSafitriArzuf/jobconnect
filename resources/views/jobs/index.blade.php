@extends('layouts.app')

@section('content')
    <h2>Daftar Lowongan Kerja</h2>

    @if(session('success'))
        <div style="color: green">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Perusahaan</th>
                <th>Lokasi</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th>Deadline</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $job)
                <tr>
                    <td>{{ $job->title }}</td>
                    <td>{{ $job->company->name ?? '-' }}</td>
                    <td>{{ $job->location }}</td>
                    <td>{{ $job->category->name ?? '-' }}</td>
                    <td>{{ $job->job_type }}</td>
                    <td>{{ $job->deadline }}</td>
                    <td>
                        <a href="{{ route('jobs.show', $job->id) }}">Lihat</a>

                        @if(auth()->user()->role == 'company')
                            | <a href="{{ route('jobs.edit', $job->id) }}">Edit</a>
                            | <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin hapus?')">Hapus</button>
                              </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
