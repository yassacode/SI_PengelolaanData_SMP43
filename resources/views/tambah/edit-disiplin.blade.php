@extends('base.layout-tambah')
@section('title','Edit Data Disiplin')
@section('add')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Data Kedisiplinan Siswa</h3>
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
                    <form action="{{ route('disiplin.update', $disiplin->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="siswa_id">Nama Siswa: <sup class="text-danger">*</sup></label>
                                    <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror">
                                        <option value="">-- Pilih Siswa --</option>
                                        @foreach ($siswa as $student)
                                            <option value="{{ $student->id }}" {{ $disiplin->siswa_id == $student->id ? 'selected' : '' }}>{{ $student->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('siswa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="masalah">Bentuk Pelanggaran: <sup class="text-danger">*</sup></label>
                                    <input type="text" id="masalah" name="masalah" class="form-control @error('masalah') is-invalid @enderror" value="{{ old('masalah', $disiplin->masalah) }}">
                                    @error('masalah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="tanggal">Tanggal Kejadian: <sup class="text-danger">*</sup></label>
                                    <input type="date" id="tanggal" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $disiplin->tanggal) }}">
                                    @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group mb-3">
                                    @if ($disiplin->foto)
                                        <div class="mb-2">
                                            <label>Foto Saat Ini:</label><br>
                                            <img src="{{ Storage::url($disiplin->foto) }}" alt="Foto Bukti" style="width: 150px;" class="rounded">
                                        </div>
                                    @endif
                                    <label for="foto">Unggah Foto Baru (Opsional):</label>
                                    <input type="file" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                                    @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary px-4">Update</button>
                            <a href="{{ route('disiplin.index') }}" class="btn btn-danger px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
