@extends('base.layout')
@section('title', 'Pengesahan Laporan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="card">
        <h4 class="card-header">Validasi & Pengesahan Laporan</h4>
        <div class="table-responsive">
            <table class="table card-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Laporan</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Tanggal Disahkan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporans as $laporan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $laporan->jenis_laporan }}</td>
                        <td>{{ $laporan->periode }}</td>
                        <td>
                            @if ($laporan->status_kepsek == 'Approved')
                                <span class="badge bg-label-success">Disahkan</span>
                            @else
                                <span class="badge bg-label-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            {{ $laporan->tgl_disahkan ? \Carbon\Carbon::parse($laporan->tgl_disahkan)->locale('id')->translatedFormat('d F Y') : '-' }}
                        </td>
                        <td>
                            @if ($laporan->status_kepsek != 'Approved')
                            <form action="{{ route('laporan.approve', $laporan->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin mengesahkan laporan ini?')">
                                    <i class="bx bx-check me-1"></i> Sahkan
                                </button>
                            </form>
                            @else
                            <button type="button" class="btn btn-sm btn-secondary" disabled>
                                <i class="bx bx-check-double me-1"></i> Selesai
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Belum ada laporan yang butuh pengesahan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
