@extends('base.layout-cetak')
@section('title','cetak disiplin')
@section('cetak')
<div class="print-container">
    @include('components.kop-surat')

    <div class="header text-center mb-4">
        <h5 style="font-weight: bold; text-decoration: underline;">LAPORAN DAFTAR PELANGGARAN SISWA</h5>
        @if($disiplin->isNotEmpty() && $month)
            <p class="mb-0">Periode: {{ \Carbon\Carbon::parse($month)->locale('id')->translatedFormat('F Y') }}</p>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="bg-light text-center">
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Nama Siswa</th>
                    <th width="10%">Kelas</th>
                    <th width="25%">Masalah</th>
                    <th width="15%">Tanggal</th>
                    <th width="25%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($disiplin as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->siswa->nama ?? '-' }}</td>
                        <td class="text-center">{{ $item->kelas ?? '-' }}</td>
                        <td>{{ $item->masalah ?? '-' }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Data tidak tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="signature-section mt-5">
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p class="mb-0">Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p class="mb-5">Wakil Kepala Kesiswaan,</p>
                <br>
                <p class="mb-0" style="font-weight: bold; text-decoration: underline;">( ................................... )</p>
                <p>NIP. .............................</p>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        window.print();
    };
</script>
@endsection



