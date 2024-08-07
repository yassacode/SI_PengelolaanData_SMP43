@extends('base.layout-tambah')
@section('add')
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>Tambah Data Siswa</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form >
                                        <div class="form-group">
                                            <label for="name_left">Nama:</label>
                                            <input type="text" id="" name="name" class="form-control" value="{{ old('name') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="email_left">NISN:</label>
                                            <input type="text" id="" name="email" class="form-control" value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="password_left">Tempat Tanggal Lahir:</label>
                                            <input type="text" id="" name="ttl" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="password_left">No HP:</label>
                                            <input type="text" id="" name="alamat" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="password_left">Alamat:</label>
                                            <input type="text" id="" name="alamat" class="form-control">
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <form >
                                        <div class="form-group">
                                            <label for="name_left">Tinggi Badan:</label>
                                            <input type="text" id="" name="name" class="form-control" value="{{ old('name') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="email_left">Berat Badan:</label>
                                            <input type="text" id="" name="email" class="form-control" value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="password_left">Agama:</label>
                                            <input type="text" id="" name="ttl" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="password_left">Hobi dan Cita Cita:</label>
                                            <input type="text" id="" name="alamat" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="password_left">Tahun Masuk:</label>
                                            <input type="text" id="" name="alamat" class="form-control">
                                        </div>
                                        <button type="button" class="btn btn-primary ml-5 mb-2">Next>>></button>
                                        <button type="button" class="btn btn-danger ml-5 mb-2">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
       @endsection

