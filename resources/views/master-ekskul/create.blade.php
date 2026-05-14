@extends('base.layout-tambah')
@section('title', 'Tambah Nama Ekskul')

@section('add')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Tambah Nama Ekstrakurikuler</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('master-ekskul.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="nama">Nama Ekskul: <sup class="text-danger">*</sup></label>
                                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: Pramuka, PMR, Rohis" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="keterangan">Keterangan Ekskul:</label>
                                <textarea id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" placeholder="Masukkan deskripsi singkat tentang ekskul ini...">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary px-4">Simpan</button>
                                <a href="{{ route('master-ekskul.index') }}" class="btn btn-danger px-4">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
