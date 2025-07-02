@extends('layouts.app')

@section('title', 'Daftar Pelamar')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Pelamar untuk: <strong>{{ $job->title }}</strong></h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($job->applications->isEmpty())
        <p>Belum ada pelamar untuk lowongan ini.</p>
    @else
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nama Pelamar</th>
                    <th>Email</th>
                    <th>Surat Lamaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($job->applications as $app)
                    <tr>
                        <td>{{ $app->user->name }}</td>
                        <td>{{ $app->user->email }}</td>
                        <td>{{ $app->cover_letter ?? '-' }}</td>
                        <td>
                            <span class="badge 
                                @if($app->status == 'accepted') bg-success
                                @elseif($app->status == 'rejected') bg-danger
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($app->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('applications.updateStatus', $app->id) }}" method="POST" class="d-flex gap-1">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm">
                                    <option value="pending" {{ $app->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ $app->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ $app->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <button class="btn btn-sm btn-primary" type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('jobs.index') }}" class="btn btn-secondary mt-3">⬅ Kembali ke Lowongan</a>
</div>
@endsection
