@extends('layouts.app')

@section('content')
    <h2>Daftar Lowongan Kerja</h2>

    @if (session('success'))
        <div style="color: green">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('jobs.create') }}">➕ Tambah Lowongan</a>
    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Perusahaan</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Deadline</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jobs as $job)
                <tr>
                    <td>{{ $job->title }}</td>
                    <td>{{ $job->company->name ?? '-' }}</td>
                    <td>{{ $job->category->name ?? '-' }}</td>
                    <td>{{ $job->location }}</td>
                    <td>{{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('jobs.show', $job->id) }}">🔍 Lihat</a> |
                        <a href="{{ route('jobs.edit', $job->id) }}">✏️ Edit</a> |
                        <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada lowongan tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
