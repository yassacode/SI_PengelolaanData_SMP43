@extends('base.layout-add')
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
                                    <label for="name_left">Asal Paud:</label>
                                    <input type="text" id="" name="name" class="form-control" value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="email_left">Asal TK:</label>
                                    <input type="text" id="" name="email" class="form-control" value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label for="password_left">Asal SD:</label>
                                    <input type="text" id="" name="ttl" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password_left">Jarak Rumah Ke Sekolah:</label>
                                    <input type="text" id="" name="alamat" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password_left">Riwayat Sakit:</label>
                                    <input type="text" id="" name="alamat" class="form-control">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form >
                                <div class="form-group">
                                    <label for="name_left">Riwayat Beasiswa:</label>
                                    <input type="text" id="" name="name" class="form-control" value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="email_left">Pernah Ikut Perlombaan Apa:</label>
                                    <input type="text" id="" name="email" class="form-control" value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label for="password_left">Dan Juara Berapa:</label>
                                    <input type="text" id="" name="ttl" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password_left">Jumlah Saudara:</label>
                                    <input type="text" id="" name="alamat" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="password_left">Anak Ke-:</label>
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