<!DOCTYPE html>
<html>
<head>
    <title>Rekapitulasi Laporan SMP 43 Padang</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2, .header h3, .header p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .section-title { background-color: #e9e9e9; padding: 5px; font-weight: bold; margin-top: 20px; border: 1px solid #000; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    <div class="header">
        <h2>SMP NEGERI 43 PADANG</h2>
        <p>Jl. Rimbo Tarok, Kel. Gunung Sarik, Kec. Kuranji, Kota Padang</p>
        <p>Email: smp43padang@gmail.com | Telp: (0751) 123456</p>
    </div>

    <h3 style="text-align: center;">REKAPITULASI LAPORAN</h3>
    <p style="text-align: center; margin-top: -10px;">
        Periode Disiplin: {{ $month_disiplin ? \Carbon\Carbon::parse($month_disiplin)->locale('id')->translatedFormat('F Y') : 'Keseluruhan' }} | 
        Periode Ekskul: {{ $month_ekskul ? \Carbon\Carbon::parse($month_ekskul)->locale('id')->translatedFormat('F Y') : 'Keseluruhan' }}
    </p>

    <div class="section-title">I. DATA PELANGGARAN SISWA (DISIPLIN)</div>
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="120">Nama Siswa</th>
                <th width="150">Masalah</th>
                <th width="100">Tanggal</th>
                <th>Keterangan</th>
                <th width="100">Pelapor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($disiplin as $index => $d)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $d->siswa->nama ?? '-' }}</td>
                <td>{{ $d->masalah }}</td>
                <td>{{ \Carbon\Carbon::parse($d->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                <td>{{ $d->keterangan }}</td>
                <td>{{ $d->pelapor->nama ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data pelanggaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">II. DATA KEGIATAN EKSTRAKURIKULER</div>
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="150">Nama Kegiatan</th>
                <th width="100">Tanggal</th>
                <th width="150">Lokasi</th>
                <th>Pembina</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ekskul as $index => $e)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $e->nama_kegiatan }}</td>
                <td>{{ \Carbon\Carbon::parse($e->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                <td>{{ $e->lokasi }}</td>
                <td>{{ $e->pembina->nama ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data kegiatan ekstrakurikuler</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right; width: 100%;">
        <p>Padang, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
        <p style="margin-bottom: 50px;">Kepala Sekolah,</p>
        <p><strong>Bapak Kepala Sekolah</strong></p>
        <p>NIP. 10000006</p>
    </div>

</body>
</html>
