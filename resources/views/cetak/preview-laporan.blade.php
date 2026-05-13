@extends('base.layout')
@section('title', 'Preview Laporan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Laporan /</span> Preview {{ $laporan->jenis_laporan }}
        </h4>
        <div class="d-flex gap-2">
            <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-chevron-left me-1"></i> Kembali
            </a>
            @if ($laporan->status_kepsek != 'Approved')
                <form action="{{ route('laporan.approve', $laporan->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin mengesahkan laporan ini?')">
                        <i class="bx bx-check me-1"></i> Sahkan Laporan
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-5">
            <!-- Simulated Paper Background -->
            <div class="p-4 bg-white" style="border: 1px solid #ddd; border-radius: 4px; color: black !important;">
                @include('components.kop-surat')

                <div class="text-center mb-4">
                    <h5 style="font-weight: bold; text-decoration: underline; text-transform: uppercase;">
                        LAPORAN {{ $laporan->jenis_laporan }} SISWA
                    </h5>
                    <p class="mb-0">Periode: {{ \Carbon\Carbon::parse($laporan->periode . '-01')->locale('id')->translatedFormat('F Y') }}</p>
                </div>

                <div class="table-responsive mt-4">
                    @if($type == 'disiplin')
                        <table class="table table-bordered border-dark">
                            <thead class="text-center" style="background-color: #f8f9fa !important; border-bottom: 2px solid black;">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Nama Siswa</th>
                                    <th width="25%">Masalah</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="20%">Pelapor</th>
                                    <th width="15%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $item->siswa->nama ?? '-' }}</td>
                                        <td>{{ $item->masalah }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                        <td>{{ $item->pelapor->nama ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-label-success">VALID</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Tidak ada data ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @else
                        <table class="table table-bordered border-dark">
                            <thead class="text-center" style="background-color: #f8f9fa !important; border-bottom: 2px solid black;">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Nama Kegiatan</th>
                                    <th width="15%">Tanggal</th>
                                    <th width="20%">Lokasi</th>
                                    <th width="20%">Pembina</th>
                                    <th width="15%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $item->kegiatan ?? $item->nama_kegiatan }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                        <td>{{ $item->lokasi }}</td>
                                        <td>{{ $item->pembina->nama ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-label-success">VALID</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Tidak ada data ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @endif
                </div>

                <div class="mt-5">
                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-4 text-center">
                            <p class="mb-0">Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                            @if($laporan->status_kepsek == 'Approved')
                                <p class="mb-5">Telah Disahkan Oleh,</p>
                                <p class="mb-0 fw-bold" style="text-decoration: underline;">Bapak Kepala Sekolah</p>
                                <p>NIP. 10000006</p>
                            @else
                                <p class="mb-5">Kepala Sekolah,</p>
                                <br>
                                <p class="mb-0 fw-bold">( ................................... )</p>
                                <p>NIP. .............................</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
