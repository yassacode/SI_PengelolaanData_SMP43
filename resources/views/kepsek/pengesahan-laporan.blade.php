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
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Validasi & Pengesahan Laporan</h4>
            <form action="{{ route('rekapitulasi.export.pdf') }}" method="GET" class="d-flex align-items-center">
                <div class="me-2 text-end">
                    <small class="d-block text-muted">Bulan Disiplin</small>
                    <input type="month" name="month_disiplin" class="form-control form-control-sm" value="{{ date('Y-m') }}">
                </div>
                <div class="me-2 text-end">
                    <small class="d-block text-muted">Bulan Ekskul</small>
                    <input type="month" name="month_ekskul" class="form-control form-control-sm" value="{{ date('Y-m') }}">
                </div>
                <button type="submit" class="btn btn-danger btn-sm align-self-end">
                    <i class="bx bxs-file-pdf me-1"></i> Cetak Rekapitulasi
                </button>
            </form>
        </div>
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
                        <td>{{ \Carbon\Carbon::parse($laporan->periode . '-01')->locale('id')->translatedFormat('F Y') }}</td>
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
                            <a href="{{ route('laporan.preview', $laporan->id) }}" class="btn btn-sm btn-info">
                                <i class="bx bx-show me-1"></i> View
                            </a>
                            @if ($laporan->status_kepsek != 'Approved')
                            <form action="{{ route('laporan.approve', $laporan->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin mengesahkan laporan ini?')">
                                    <i class="bx bx-check me-1"></i> Sahkan
                                </button>
                            </form>
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
