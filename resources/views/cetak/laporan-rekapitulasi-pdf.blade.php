<!DOCTYPE html>
<html>
<head>
    <title>Rekapitulasi Laporan SMP 43 Padang</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 10pt; 
            line-height: 1.4;
            color: #333;
        }
        .kop-surat {
            border-bottom: 3px solid black;
            margin-bottom: 2px;
            padding-bottom: 10px;
            text-align: center;
        }
        .kop-surat h2, .kop-surat h3, .kop-surat h4 {
            margin: 0;
            text-transform: uppercase;
        }
        .line-thick { border-top: 2px solid black; margin-top: 2px; }
        .line-thin { border-top: 1px solid black; margin-top: 1px; margin-bottom: 20px; }
        
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            text-decoration: underline;
            margin-bottom: 5px;
        }
        .subtitle {
            text-align: center;
            margin-bottom: 20px;
            font-size: 11pt;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        table, th, td { 
            border: 1px solid black; 
        }
        th { 
            background-color: #f2f2f2; 
            padding: 8px;
            font-weight: bold;
            text-align: center;
        }
        td { 
            padding: 6px; 
            vertical-align: top;
        }
        .text-center { text-align: center; }
        
        .section-header {
            background-color: #eee;
            padding: 5px 10px;
            font-weight: bold;
            margin-bottom: 10px;
            border: 1px solid #000;
        }
        
        .footer {
            margin-top: 30px;
            float: right;
            width: 300px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h4>PEMERINTAH KOTA PADANG</h4>
        <h4>DINAS PENDIDIKAN DAN KEBUDAYAAN</h4>
        <h3>SMP NEGERI 43 PADANG</h3>
        <p style="font-size: 9pt; font-style: italic; margin: 2px 0;">
            Jl. Rimbo Tarok, Kel. Gunung Sarik, Kec. Kuranji, Kota Padang. Telp: (0751) 123456
        </p>
    </div>
    <div class="line-thick"></div>
    <div class="line-thin"></div>

    <div class="title">REKAPITULASI LAPORAN SEKOLAH</div>
    <div class="subtitle">
        Periode: 
        {{ $month_disiplin ? \Carbon\Carbon::parse($month_disiplin)->locale('id')->translatedFormat('F Y') : 'Semua' }} (Disiplin) & 
        {{ $month_ekskul ? \Carbon\Carbon::parse($month_ekskul)->locale('id')->translatedFormat('F Y') : 'Semua' }} (Ekskul)
    </div>

    <div class="section-header">I. DATA PELANGGARAN SISWA</div>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Siswa</th>
                <th width="25%">Masalah / Pelanggaran</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Pelapor</th>
                <th width="15%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($disiplin as $index => $d)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $d->siswa->nama ?? '-' }}</td>
                <td>{{ $d->masalah }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $d->pelapor->nama ?? '-' }}</td>
                <td>{{ $d->keterangan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data pelanggaran</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-header">II. DATA KEGIATAN EKSTRAKURIKULER</div>
    <table>
        <thead>
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
            @forelse($ekskul as $index => $e)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $e->kegiatan ?? $e->nama_kegiatan }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($e->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $e->lokasi }}</td>
                <td>{{ $e->pembina->nama ?? '-' }}</td>
                <td class="text-center">VALID</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data kegiatan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p style="margin-bottom: 60px;">Kepala Sekolah,</p>
        <p><strong>Bapak Kepala Sekolah</strong></p>
        <p>NIP. 10000006</p>
    </div>

</body>
</html>
