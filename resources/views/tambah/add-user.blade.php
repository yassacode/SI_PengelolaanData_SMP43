@extends('base.layout-tambah')
@section('title','add user')
@section('add')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Tambah User</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                     <div class="row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama :</label>
                                    <input type="text" id="" name="name" class="form-control" placeholder="Masukan Nama lengkap beserta gelar..">
                                </div>
                                <div class="form-group">
                                    <label for="">username:</label>
                                    <input type="text" id="" name="email" class="form-control"placeholder="masukan username anda sebagai username login">
                                </div>
                                <div class="form-password-toggle">
                                    <label class="form-label" for="basic-default-password12">Password</label>
                                    <div class="input-group">
                                      <input name="password" type="password" class="form-control" id="basic-default-password12" placeholder="Silahkan Masukan Password" aria-describedby="basic-default-password2" />
                                      <span id="basic-default-password2" class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1" class="form-label">level user</label>
                                    <select name="level" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                     <option selected>...</option>
                                     <option value="admin">admin</option>
                                     <option value="kepala sekolah">Kepala Sekolah</option>
                                     <option value="waka kesiswaan">Waka Kesiswaan</option>
                                     <option value="staff waka kesiswaan">Staff Waka Kesiswaan</option>
                                     <option value="guru">Guru</option>
                                    </select>
                                </div>
                        </div>
                     <div class="col-md-6">
                             
                                <div class="form-group">
                                    <label for="">Jabatan:</label>
                                    <input type="text" id="" name="jabatan" class="form-control"placeholder="Silahkan masukan jabatan anda">
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">NIP:</label>
                                    <input class="form-control" type="text" id="" name="nip"placeholder="masukan NIP anda">    
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Alamat:</label>
                                    <input class="form-control" type="text" id="" name="alamat"placeholder="Masukan Alamat domisili anda">    
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Nomor HP:</label>
                                    <input class="form-control" type="text" id="" name="no_hp"placeholder="masukan no hp yang bisa dihubungi">    
                                </div>
                         </div>
                                <div class="mt-4 text-center">
                                    <button type="submit" class="btn btn-primary ">Submit</button>
                                    <button type="button" class="btn btn-danger">Cancel</button>
                                </div>
                    </form>
                 </div>
                </div>
            </div>
        </div>
    </div>
</div> 

@endsection