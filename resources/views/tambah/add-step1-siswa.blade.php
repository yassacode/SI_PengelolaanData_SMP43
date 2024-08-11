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
                                    <form action="{{ route('siswa.store1') }}" method="POST">
                                        @csrf
                                       
                                        <div class="form-group">
                                            <label for="">Nama:</label>
                                            <input type="text" id="" name="nama" class="form-control" placeholder="Silahkan Masukan Nama lengkap">
                                        </div>
                                        <div class="form-group">
                                            <label for="">NISN:</label>
                                            <input type="text" id="" name="nisn" class="form-control" placeholder="Silahkan Masukan NISN">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Tempat Tanggal Lahir:</label>
                                            <input type="text" id="" name="ttl" class="form-control"placeholder="masukan tempat tanggal lahir">
                                        </div>
                                        <div class="form-group">
                                            <label for="">No HP:</label>
                                            <input type="text" id="" name="no_hp" class="form-control"placeholder="No HP siswa">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Alamat:</label>
                                            <input type="text" id="" name="alamat" class="form-control"placeholder="Alamat Siswa">
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tinggi Badan:</label>
                                            <input type="text" id="" name="tb" class="form-control" placeholder="Tinggi badan siswa">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Berat Badan:</label>
                                            <input type="text" id="" name="bb" class="form-control" placeholder="berat badan siswa">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Agama:</label>
                                            <input type="text" id="" name="agama" class="form-control"placeholder="Agama Siswa">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Hobi dan Cita Cita:</label>
                                            <input type="text" id="" name="hobi" class="form-control" placeholder="masukan hobi dan cita cita">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Tahun Masuk:</label>
                                            <input type="text" id="" name="thn_msk" class="form-control" placeholder="tahun masuk siswa ke SMP 43 Padang">
                                        </div>
                                        <div class="form-group text-center mt-3">
                                            <button type="submit" class="btn btn-primary">Next</button>
                                            <a href="{{route('siswa.index')}}"><i class="btn btn-danger">cancel</i></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
       @endsection

