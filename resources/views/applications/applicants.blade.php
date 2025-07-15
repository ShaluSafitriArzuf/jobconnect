@extends('layouts.app')

@section('title', 'Daftar Pelamar')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4"><i class="bi bi-person-lines-fill me-2"></i>Daftar Pelamar</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($applications->count())
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Pelamar</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Tanggal Lamar</th>
                        <th>CV</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr>
                            <td>{{ $application->user->name }}</td>
                            <td>{{ $application->user->email }}</td>
                            <td>
                                <form method="POST" action="{{ route('company.applications.updateStatus', $application->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select" onchange="confirmChange(this)">
                                        <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                        <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </form>
                            </td>
                            <td>{{ $application->created_at->format('d M Y') }}</td>
                            <td>
                                @if ($application->cv_path)
                                    <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat CV</a>
                                @else
                                    <em>Tidak ada</em>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $application->id }}">
                                    Detail
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="detailModal{{ $application->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Lamaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Nama:</strong> {{ $application->user->name }}</p>
                                        <p><strong>Email:</strong> {{ $application->user->email }}</p>
                                        <p><strong>Domisili:</strong> {{ $application->domicile }}</p>
                                        <p><strong>Telepon:</strong> {{ $application->phone }}</p>
                                        <p><strong>Pengalaman:</strong> {{ $application->experience }}</p>
                                        <p><strong>Pendidikan:</strong> {{ $application->education }}</p>
                                        <p><strong>Ketersediaan:</strong> 
                                            @switch($application->availability)
                                                @case('segera') Segera @break
                                                @case('1_minggu') Dalam 1 Minggu @break
                                                @case('1_bulan') Dalam 1 Bulan @break
                                                @default - 
                                            @endswitch
                                        </p>
                                        <p><strong>Pesan Pengantar / Motivasi:</strong><br>{!! nl2br(e($application->cover_letter)) !!}</p>
                                        @if ($application->portfolio_link)
                                            <p><strong>Portofolio:</strong> <a href="{{ $application->portfolio_link }}" target="_blank">Lihat</a></p>
                                        @endif
                                        @if ($application->linkedin_link)
                                            <p><strong>LinkedIn:</strong> <a href="{{ $application->linkedin_link }}" target="_blank">Lihat</a></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $applications->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">Belum ada pelamar untuk lowongan ini.</div>
    @endif
</div>

<!-- Konfirmasi Ubah Status -->
<script>
    function confirmChange(select) {
        if (confirm('Yakin ingin mengubah status pelamar ini?')) {
            select.form.submit();
        } else {
            window.location.reload();
        }
    }
</script>
@endsection
