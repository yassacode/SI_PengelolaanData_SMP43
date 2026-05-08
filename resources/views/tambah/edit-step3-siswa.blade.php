@extends('base.layout-tambah')
@section('title','Edit Data Siswa - Step 3')
@section('add')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Data Siswa <small class="text-muted">— Step 3: Data Wali</small></h3>
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
                    <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3">Data Ayah</h5>
                                <div class="form-group mb-3">
                                    <label for="nama_ayah">Nama Ayah:</label>
                                    <input type="text" id="nama_ayah" name="nama_ayah" class="form-control" value="{{ old('nama_ayah', $siswa->wali->nama_ayah ?? '') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pekerjaan_ayah">Pekerjaan Ayah:</label>
                                    <input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" class="form-control" value="{{ old('pekerjaan_ayah', $siswa->wali->pekerjaan_ayah ?? '') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="no_hp_ayah">No HP Ayah:</label>
                                    <input type="text" id="no_hp_ayah" name="no_hp_ayah" class="form-control" value="{{ old('no_hp_ayah', $siswa->wali->no_hp_ayah ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Data Ibu</h5>
                                <div class="form-group mb-3">
                                    <label for="nama_ibu">Nama Ibu:</label>
                                    <input type="text" id="nama_ibu" name="nama_ibu" class="form-control" value="{{ old('nama_ibu', $siswa->wali->nama_ibu ?? '') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="pekerjaan_ibu">Pekerjaan Ibu:</label>
                                    <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" class="form-control" value="{{ old('pekerjaan_ibu', $siswa->wali->pekerjaan_ibu ?? '') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="no_hp_ibu">No HP Ibu:</label>
                                    <input type="text" id="no_hp_ibu" name="no_hp_ibu" class="form-control" value="{{ old('no_hp_ibu', $siswa->wali->no_hp_ibu ?? '') }}">
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('siswa.edit2', $siswa->id) }}" class="btn btn-warning px-4">← Kembali</a>
                            <a href="{{ route('siswa.index') }}" class="btn btn-danger px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
