@extends('base.layout-tambah')
@section('title', 'Tambah Data Siswa - Step 1')
@section('add')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Tambah Data Siswa <small class="text-muted">— Step 1: Data Pribadi</small></h3>
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
                        <form action="{{ route('siswa.store1') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nama">Nama Lengkap: <sup class="text-danger">*</sup></label>
                                        <input type="text" id="nama" name="nama" class="form-control"
                                            placeholder="Masukan nama lengkap siswa"
                                            value="{{ old('nama', session('siswa_step1.nama')) }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="nisn">NISN: <sup class="text-danger">*</sup></label>
                                        <input type="text" id="nisn" name="nisn" class="form-control"
                                            placeholder="Masukan NISN"
                                            value="{{ old('nisn', session('siswa_step1.nisn')) }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="ttl">Tempat Tanggal Lahir: <sup class="text-danger">*</sup></label>
                                        <input type="text" id="ttl" name="ttl" class="form-control"
                                            placeholder="Contoh: Padang, 01 Januari 2010"
                                            value="{{ old('ttl', session('siswa_step1.ttl')) }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="tb">Tinggi Badan: <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <input type="number" id="tb" name="tb" class="form-control"
                                                placeholder="Contoh: 160"
                                                value="{{ old('tb', session('siswa_step1.tb')) }}">

                                            <span class="input-group-text">CM</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="agama">Agama: <sup class="text-danger">*</sup></label>
                                        <input type="text" id="agama" name="agama" class="form-control"
                                            placeholder="Agama siswa"
                                            value="{{ old('agama', session('siswa_step1.agama')) }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="hobi">Hobi:</label>
                                        <input type="text" id="hobi" name="hobi" class="form-control"
                                            placeholder="Hobi siswa (opsional)"
                                            value="{{ old('hobi', session('siswa_step1.hobi')) }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="thn_msk">Tahun Masuk: <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <span class="input-group-text">Tahun</span>
                                            <input type="text" id="thn_msk" name="thn_msk" class="form-control"
                                                placeholder="Contoh: 2024"
                                                value="{{ old('thn_msk', session('siswa_step1.thn_msk')) }}">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="bb">Berat Badan: <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <input type="number" id="bb" name="bb" class="form-control"
                                                placeholder="Contoh: 40" value="{{ old('bb', session('siswa_step1.bb')) }}">

                                            <span class="input-group-text">KG</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="alamat">Alamat:</label>
                                        <textarea id="alamat" name="alamat" class="form-control" rows="2" placeholder="masukan alamat tinggal">{{ old('alamat', session('siswa_step1.alamat')) }}</textarea>
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
