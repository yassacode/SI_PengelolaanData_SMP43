@extends('base.layout-tambah')
@section('add')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3>Tambah Data Siswa</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.store') }}" method="POST">
                        @csrf   
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_ayah">Nama Ayah:</label>
                                    <input type="text" id="nama_ayah" name="nama_ayah" class="form-control" value="{{ old('nama_ayah') }}">
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan_ayah">Pekerjaan Ayah:</label>
                                    <input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" class="form-control" value="{{ old('pekerjaan_ayah') }}">
                                </div>
                                <div class="form-group">
                                    <label for="alamat_ayah">Alamat Ayah:</label>
                                    <input type="text" id="alamat_ayah" name="alamat_ayah" class="form-control" value="{{ old('alamat_ayah') }}">
                                </div>
                                <div class="form-group">
                                    <label for="no_hp_ayah">No Hp Ayah:</label>
                                    <input type="text" id="no_hp_ayah" name="no_hp_ayah" class="form-control" value="{{ old('no_hp_ayah') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_ibu">Nama Ibu:</label>
                                    <input type="text" id="nama_ibu" name="nama_ibu" class="form-control" value="{{ old('nama_ibu') }}">
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan_ibu">Pekerjaan Ibu:</label>
                                    <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" class="form-control" value="{{ old('pekerjaan_ibu') }}">
                                </div>
                                <div class="form-group">
                                    <label for="alamat_ibu">Alamat Ibu:</label>
                                    <input type="text" id="alamat_ibu" name="alamat_ibu" class="form-control" value="{{ old('alamat_ibu') }}">
                                </div>
                                <div class="form-group">
                                    <label for="no_hp_ibu">No HP Ibu:</label>
                                    <input type="text" id="no_hp_ibu" name="no_hp_ibu" class="form-control" value="{{ old('no_hp_ibu') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_wali">Nama Wali:</label>
                                    <input type="text" id="nama_wali" name="nama_wali" class="form-control" value="{{ old('nama_wali') }}">
                                </div>
                                <div class="form-group">
                                    <label for="nama_wali"> Identitas Wali:</label>
                                    <input type="text" id="identitas_wali" name="identitas_wali" class="form-control" value="{{ old('nama_wali') }}">
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan_wali">Pekerjaan Wali:</label>
                                    <input type="text" id="pekerjaan_wali" name="pekerjaan_wali" class="form-control" value="{{ old('pekerjaan_wali') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="alamat_wali">Alamat Wali:</label>
                                    <input type="text" id="alamat_wali" name="alamat_wali" class="form-control" value="{{ old('alamat_wali') }}">
                                </div>
                                <div class="form-group">
                                    <label for="no_hp_wali">No HP Wali:</label>
                                    <input type="text" id="no_hp_wali" name="no_hp_wali" class="form-control" value="{{ old('no_hp_wali') }}">
                                </div>
                                <div class="form-group text-center mt-4">
                                    <a href="{{ route('siswa.create2') }}" class="btn btn-warning">back</a>
                                    <button type="reset" class="btn btn-danger">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>>  
@endsection