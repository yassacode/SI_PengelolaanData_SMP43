@extends('base.layout-cetak')

@section('cetak')
    <div class=" container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="header mt-3">
                <h4> SMP Negeri 43 Padang</h4>
                <br>
                <h5 class="text-center ">BIODATA DIRI SISWA </h5>
                @if (($students->status ?? null) === 'ACCEPTED')
                    <a class="nav-link" href="{{ route('siswa.show2', $students->id) }}"><button type="button"
                            class="btn btn-primary">cetak</button></a>
                @endif
            </div>
            <div>
                <table class="table-borderless">
                    <tbody>
                        <tr>
                            <td>User</td>
                            <td>:</td>
                            <td>{{ $students->user->nama }}</td>
                        </tr>
                        <tr>
                            <td>Nama Lengkap</td>
                            <td>:</td>
                            <td>{{ $students->nama ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Tempat/tanggal lahir</td>
                            <td>:</td>
                            <td>{{ $students->ttl ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Asal SD</td>
                            <td>:</td>
                            <td>{{ $students->akademik->asal_sd ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Asal TK</td>
                            <td>:</td>
                            <td>{{ $students->akademik->asal_tk ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Asal PAUD</td>
                            <td>:</td>
                            <td>{{ $students->akademik->asal_paud ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td>{{ $students->agama ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>{{ $students->alamat ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Hobi dan Cita-cita</td>
                            <td>:</td>
                            <td>{{ $students->hobi ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Penyakit yang pernah diderita</td>
                            <td>:</td>
                            <td>{{ $students->kesehatan->riwayat_sakit ?? 'Tidak Ada' }}</td>
                        </tr>
                        <tr>
                            <td>Beasiswa yang pernah diterima</td>
                            <td>:</td>
                            <td>{{ $students->akademik->beasiswa ?? 'Tidak Ada' }}</td>
                        </tr>
                        <tr>
                            <td>Orang Tua</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class=" mb-0">Nama Ayah</ul>
                            </td>
                            <td>:</td>
                            <td>{{ $students->wali->nama_ayah ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>
                                <ul class=" mb-0">Pekerjaan Ayah</ul>
                            </td>
                            <td>:</td>
                            <td>{{ $students->wali->pekerjaan_ayah ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>
                                <ul class=" mb-0">Alamat </ul>
                            </td>
                            <td>:</td>
                            <td>{{ $students->wali->alamat_ayah ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>
                                <ul class=" mb-0">Nama Ibu</ul>
                            <td>:</td>
                            <td>{{ $students->wali->nama_ibu ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>
                                <ul class=" mb-0">Pekerjaan Ibu</ul>
                            <td>:</td>
                            <td>{{ $students->wali->pekerjaan_ibu ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>
                                <ul class=" mb-0">Alamat</ul>
                            <td>:</td>
                            <td>{{ $students->wali->alamat_ibu ?? '' }}</td>
                        </tr>


                        <tr>
                            <td>Jarak tempuh ke sekolah</td>
                            <td>:</td>
                            <td>{{ $students->akademik->jrk_sklh ?? '' }}</td>
                        </tr>

                        <tr>
                            <td>No. HP Ayah</td>
                            <td>:</td>
                            <td>{{ $students->wali->no_hp_ayah ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>No. HP Ibu</td>
                            <td>:</td>
                            <td>{{ $students->wali->no_hp_ibu ?? '' }}</td>
                        </tr>

                        <tr>
                            <td>Prestasi Akademi dan Non Akademik</td>
                            <td>:</td>
                            <td>
                                @if($students->prestasis->count() > 0)
                                    <table class="table table-sm table-bordered mt-2">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kegiatan</th>
                                                <th>Juara</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($students->prestasis as $index => $prestasi)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $prestasi->kegiatan }}</td>
                                                    <td>{{ $prestasi->juara }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <span class="text-muted">Tidak ada data prestasi</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
