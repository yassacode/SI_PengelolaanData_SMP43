@extends('base.layout')
@section('title', 'Preview Laporan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Preview Laporan: {{ $laporan->jenis_laporan }}</h4>
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <h5>Periode: {{ \Carbon\Carbon::parse($laporan->periode . '-01')->locale('id')->translatedFormat('F Y') }}</h5>
            
            <div class="table-responsive mt-4">
                @if($type == 'disiplin')
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Masalah</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Pelapor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->siswa->nama ?? '-' }}</td>
                                    <td>{{ $item->masalah }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>{{ $item->pelapor->nama ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data pelanggaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Lokasi</th>
                                <th>Pembina</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_kegiatan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                                    <td>{{ $item->lokasi }}</td>
                                    <td>{{ $item->pembina->nama ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data ekstrakurikuler</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            </div>

            @if ($laporan->status_kepsek != 'Approved')
                <div class="mt-4 text-end">
                    <form action="{{ route('laporan.approve', $laporan->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin mengesahkan laporan ini?')">
                            <i class="bx bx-check me-1"></i> Sahkan Laporan Sekarang
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
