@extends('base.layout')
@section('title', 'Daftar Anggota ' . $ekskul->nama)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h4 class="card-header">Daftar Siswa Mengikuti Ekskul: <strong>{{ $ekskul->nama }}</strong></h4>
            <div class="table-responsive">
                <div class="d-flex justify-content-start mb-3 px-3">
                    <a href="{{ route('master-ekskul.index') }}" class="btn btn-secondary"><i class='bx bx-arrow-back'></i> Kembali</a>
                </div>
                <table class="table card-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Tahun Masuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ekskul->siswas as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->nisn }}</td>
                                <td>{{ $siswa->nama }}</td>
                                <td>{{ $siswa->thn_msk }}</td>
                                <td>
                                    <a href="{{ route('siswa.show1', $siswa->id) }}" class="btn btn-sm btn-info">Lihat Profil</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada siswa yang terdaftar di ekskul ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
