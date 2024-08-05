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
                                    <label for="">Nama Ayah:</label>
                                    <input type="text" id="" name="name" class="form-control" value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Pekerjaan Ayah:</label>
                                    <input type="text" id="" name="email" class="form-control" value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat Ayah:</label>
                                    <input type="text" id="" name="ttl" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">No Hp Ayah:</label>
                                    <input type="text" id="" name="alamat" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Ibu:</label>
                                    <input type="text" id="" name="alamat" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Pekerjaan Ibu:</label>
                                    <input type="text" id="" name="alamat" class="form-control">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form >
                                <div class="form-group">
                                    <label for="name_left">Alamat Ibu:</label>
                                    <input type="text" id="" name="name" class="form-control" value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="">No HP Ibu:</label>
                                    <input type="text" id="" name="email" class="form-control" value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Wali:</label>
                                    <input type="text" id="" name="ttl" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Pekerjaan Wali:</label>
                                    <input type="text" id="" name="alamat" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat Wali:</label>
                                    <input type="text" id="" name="alamat" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">No HP Wali:</label>
                                    <input type="text" id="" name="alamat" class="form-control">
                                </div>
                                <button type="button" class="btn btn-primary ml-5 mb-2">Submit</button>
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