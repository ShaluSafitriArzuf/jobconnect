@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Perusahaan</h1>

        @if (session('success'))
            <div style="color: green">{{ session('success') }}</div>
        @endif

        <a href="{{ route('companies.create') }}">+ Tambah Perusahaan</a>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Lokasi</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                    <tr>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->location }}</td>
                        <td>{{ $company->description }}</td>
                        <td>
                            <a href="{{ route('companies.edit', $company->id) }}">Edit</a> |
                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
