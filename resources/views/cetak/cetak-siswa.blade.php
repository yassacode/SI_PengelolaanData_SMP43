@extends('base.layout-cetak')
@section('title', 'cetak siswa')
@section('cetak')
    <div class="print-container">
        @include('components.kop-surat')

        <div class="header text-center mb-4">
            <h5 style="font-weight: bold; text-decoration: underline;">BIODATA DIRI SISWA</h5>
        </div>

        <div class="content-siswa">
            <table class="table table-borderless mb-4">
                <tbody>
                    <tr>
                        <td width="30%">Nama Lengkap</td>
                        <td width="2%">:</td>
                        <td style="font-weight: bold;">{{ $student->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Tempat/Tanggal Lahir</td>
                        <td>:</td>
                        <td>{{ $student->ttl ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>:</td>
                        <td>{{ $student->agama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $student->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Hobi</td>
                        <td>:</td>
                        <td>{{ $student->hobi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Asal Sekolah</td>
                        <td>:</td>
                        <td>
                            SD: {{ $student->akademik->asal_sd ?? '-' }}<br>
                            TK: {{ $student->akademik->asal_tk ?? '-' }}<br>
                            PAUD: {{ $student->akademik->asal_paud ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Jarak ke Sekolah</td>
                        <td>:</td>
                        <td>{{ $student->akademik->jrk_sklh ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Beasiswa</td>
                        <td>:</td>
                        <td>{{ $student->akademik->beasiswa ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Riwayat Kesehatan</td>
                        <td>:</td>
                        <td>{{ $student->kesehatan->riwayat_sakit ?? 'Tidak Ada' }}</td>
                    </tr>
                </tbody>
            </table>

            <h6 style="font-weight: bold;" class="mb-2">Data Orang Tua / Wali</h6>
            <table class="table table-bordered mb-4">
                <thead>
                    <tr class="text-center bg-light">
                        <th>Keterangan</th>
                        <th>Ayah</th>
                        <th>Ibu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: bold;">Nama</td>
                        <td>{{ $student->wali->nama_ayah ?? '-' }}</td>
                        <td>{{ $student->wali->nama_ibu ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Pekerjaan</td>
                        <td>{{ $student->wali->pekerjaan_ayah ?? '-' }}</td>
                        <td>{{ $student->wali->pekerjaan_ibu ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">No. HP</td>
                        <td>{{ $student->wali->no_hp_ayah ?? '-' }}</td>
                        <td>{{ $student->wali->no_hp_ibu ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">Alamat</td>
                        <td>{{ $student->wali->alamat_ayah ?? '-' }}</td>
                        <td>{{ $student->wali->alamat_ibu ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>

            @if($student->prestasis->isNotEmpty())
            <h6 style="font-weight: bold;" class="mb-2">Prestasi Akademik & Non-Akademik</h6>
            <table class="table table-bordered mb-4">
                <thead>
                    <tr class="text-center bg-light">
                        <th width="10%">No</th>
                        <th>Kegiatan / Lomba</th>
                        <th>Capaian / Juara</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student->prestasis as $index => $prestasi)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $prestasi->kegiatan ?? '-' }}</td>
                            <td>{{ $prestasi->juara ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        <div class="signature-section mt-5">
            <div class="row">
                <div class="col-8"></div>
                <div class="col-4 text-center">
                    <p class="mb-0">Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p class="mb-5">Petugas Administrasi,</p>
                    <br>
                    <p class="mb-0" style="font-weight: bold; text-decoration: underline;">( ................................... )</p>
                    <p>NIP. .............................</p>
                </div>
            </div>
        </div>

        @if (!$discipline->isEmpty())
        <div class="page-break"></div>
        @include('components.kop-surat')
        <div class="header text-center mb-4">
            <h5 style="font-weight: bold; text-decoration: underline;">LAPORAN PENANGANAN MASALAH SISWA</h5>
        </div>
        
        <table class="table table-borderless mb-2">
            <tr>
                <td width="15%">Nama</td>
                <td width="2%">:</td>
                <td style="font-weight: bold;">{{ $student->nama }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>:</td>
                <td>{{ $discipline->first()->kelas ?? '-' }}</td>
            </tr>
        </table>

        <table class="table table-bordered">
            <thead class="bg-light text-center">
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Tanggal</th>
                    <th width="25%">Masalah</th>
                    <th width="25%">Solusi</th>
                    <th width="30%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($discipline as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $item->masalah }}</td>
                        <td>{{ $item->solusi }}</td>
                        <td>{{ $item->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
@endsection
