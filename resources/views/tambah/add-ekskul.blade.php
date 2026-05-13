@extends('base.layout-tambah')
@section('title', 'Tambah Kegiatan Ekskul')
@section('add')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Tambah Kegiatan Ekstrakurikuler</h3>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('ekskul.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nama_kegiatan">Nama Kegiatan: <sup class="text-danger">*</sup></label>
                                        <input type="text" id="nama_kegiatan" name="nama_kegiatan"
                                            class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                            placeholder="Contoh: Latihan Pramuka, Lomba Drumband"
                                            value="{{ old('nama_kegiatan') }}">
                                        @error('nama_kegiatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="lokasi">Lokasi: <sup class="text-danger">*</sup></label>
                                        <input type="text" id="lokasi" name="lokasi"
                                            class="form-control @error('lokasi') is-invalid @enderror"
                                            placeholder="Contoh: Lapangan Sekolah" value="{{ old('lokasi') }}">
                                        @error('lokasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="tanggal">Tanggal Kegiatan: <sup class="text-danger">*</sup></label>
                                        <input type="date" id="tanggal" name="tanggal"
                                            class="form-control @error('tanggal') is-invalid @enderror"
                                            value="{{ old('tanggal') }}">
                                        @error('tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="foto">Foto Kegiatan (Opsional):</label>
                                        <input type="file" id="foto" name="foto"
                                            class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="keterangan">Keterangan Kegiatan:</label>
                                        <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                            rows="3" placeholder="Masukkan detail atau keterangan kegiatan di sini...">{{ old('keterangan', $ekskul->keterangan ?? '') }}</textarea>

                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary px-4">Simpan</button>
                                <a href="{{ route('ekskul.index') }}" class="btn btn-danger px-4">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
