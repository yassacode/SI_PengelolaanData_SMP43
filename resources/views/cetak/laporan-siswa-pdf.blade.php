<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Siswa</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h2, .header h3, .header p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <div class="header">
        <h2>SMP NEGERI 43 PADANG</h2>
        <p>Jl. Rimbo Tarok, Kel. Gunung Sarik, Kec. Kuranji, Kota Padang</p>
        <p>Email: smp43padang@gmail.com | Telp: (0751) 123456</p>
    </div>

    <h3 style="text-align: center;">LAPORAN DATA SISWA</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Tahun Masuk</th>
                <th>Asal Sekolah</th>
                <th>Status Akademik</th>
                <th>Nama Wali</th>
                <th>No HP Wali</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswa as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->nisn }}</td>
                <td>{{ $item->thn_msk }}</td>
                <td>{{ $item->akademik->asal_sd ?? '-' }}</td>
                <td>{{ $item->akademik->status ?? '-' }}</td>
                <td>{{ $item->wali->nama_ayah ?? '-' }}</td>
                <td>{{ $item->wali->no_hp_ayah ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right; width: 100%;">
        <p>Padang, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
        <p style="margin-bottom: 60px;">Kepala Sekolah,</p>
        <p><strong>Bapak Kepala Sekolah</strong></p>
        <p>NIP. 10000006</p>
    </div>

</body>
</html>
