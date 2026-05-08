@extends('base.layout-tambah')
@section('title','Edit Data Siswa - Step 1')
@section('add')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Data Siswa <small class="text-muted">— Step 1: Data Pribadi</small></h3>
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
                    <form action="{{ route('siswa.update1', $siswa->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama">Nama Lengkap: <sup class="text-danger">*</sup></label>
                                    <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $siswa->nama) }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nisn">NISN: <sup class="text-danger">*</sup></label>
                                    <input type="text" id="nisn" name="nisn" class="form-control" value="{{ old('nisn', $siswa->nisn) }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="ttl">Tempat Tanggal Lahir: <sup class="text-danger">*</sup></label>
                                    <input type="text" id="ttl" name="ttl" class="form-control" value="{{ old('ttl', $siswa->ttl) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="agama">Agama: <sup class="text-danger">*</sup></label>
                                    <input type="text" id="agama" name="agama" class="form-control" value="{{ old('agama', $siswa->agama) }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="hobi">Hobi:</label>
                                    <input type="text" id="hobi" name="hobi" class="form-control" value="{{ old('hobi', $siswa->hobi) }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="thn_msk">Tahun Masuk: <sup class="text-danger">*</sup></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Tahun</span>
                                        <input type="text" id="thn_msk" name="thn_msk" class="form-control" value="{{ old('thn_msk', $siswa->thn_msk) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('siswa.index') }}" class="btn btn-danger px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Lanjut →</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
