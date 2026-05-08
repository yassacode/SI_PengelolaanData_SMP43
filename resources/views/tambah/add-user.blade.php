@extends('base.layout-tambah')
@section('title','Tambah User')
@section('add')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Tambah User</h3>
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
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nama">Nama Lengkap: <sup class="text-danger">*</sup></label>
                                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Masukan nama lengkap beserta gelar" value="{{ old('nama') }}">
                                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="username">Username: <sup class="text-danger">*</sup></label>
                                    <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username untuk login" value="{{ old('username') }}">
                                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email">Email: <sup class="text-danger">*</sup></label>
                                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukan email aktif" value="{{ old('email') }}">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Password: <sup class="text-danger">*</sup></label>
                                    <div class="input-group">
                                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Masukan password">
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="roles">Role User: <sup class="text-danger">*</sup></label>
                                    <select name="roles[]" id="roles" class="form-select @error('roles') is-invalid @enderror">
                                        <option value="">-- Pilih Role --</option>
                                        <option value="Admin" {{ old('roles.0') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="Staff Kesiswaan" {{ old('roles.0') == 'Staff Kesiswaan' ? 'selected' : '' }}>Staff Kesiswaan</option>
                                        <option value="Guru" {{ old('roles.0') == 'Guru' ? 'selected' : '' }}>Guru</option>
                                        <option value="Guru BK" {{ old('roles.0') == 'Guru BK' ? 'selected' : '' }}>Guru BK</option>
                                        <option value="Waka Kesiswaan" {{ old('roles.0') == 'Waka Kesiswaan' ? 'selected' : '' }}>Waka Kesiswaan</option>
                                        <option value="Kepala Sekolah" {{ old('roles.0') == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                    </select>
                                    @error('roles')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="jabatan">Jabatan: <sup class="text-danger">*</sup></label>
                                    <input type="text" id="jabatan" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" placeholder="Contoh: Guru Mata Pelajaran" value="{{ old('jabatan') }}">
                                    @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nip">NIP:</label>
                                    <input type="text" id="nip" name="nip" class="form-control" placeholder="Masukan NIP (opsional)" value="{{ old('nip') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="alamat">Alamat:</label>
                                    <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Masukan alamat domisili" value="{{ old('alamat') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="no_hp">Nomor HP:</label>
                                    <input type="text" id="no_hp" name="no_hp" class="form-control" placeholder="Masukan no hp yang bisa dihubungi" value="{{ old('no_hp') }}">
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                            <a href="{{ route('user.index') }}" class="btn btn-danger px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
