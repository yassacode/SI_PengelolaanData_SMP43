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
                                    <form action="{{ route('siswa.update1',$siswa->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="">Nama: <sup style="color:red">*</sup></label>
                                            <input type="text" id="" name="nama" class="form-control" placeholder="Silahkan Masukan Nama lengkap"value="{{$siswa->nama}}>
                                        </div>
                                        <div class="form-group">
                                            <label for="">NISN:</label>
                                            <input type="text" id="" name="nisn" class="form-control" placeholder="Silahkan Masukan NISN"value="{{$siswa->nisn}}>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Tempat Tanggal Lahir: <sup style="color:red">*</sup></label>
                                            <input type="text" id="" name="ttl" class="form-control"placeholder="masukan tempat tanggal lahir"value="{{$siswa->ttl}}>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Agama: <sup style="color:red">*</sup></label>
                                            <input type="text" id="" name="agama" class="form-control"placeholder="Agama Siswa"value="{{$siswa->agama}}>
                                        </div>
                                        <div class="form-group">
                                            <label for="">No HP: <sup style="color:red">*</sup></label>
                                            <input type="text" id="" name="no_hp" class="form-control"placeholder="No HP siswa/No HP yang bisa dihubungi"value="{{$siswa->no_hp}}>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Alamat: <sup style="color:red">*</sup></label>
                                            <input type="text" id="" name="alamat" class="form-control"placeholder="Alamat Siswa"value="{{$siswa->alamat}}>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">tinggi badan:  <sup style="color:red">*</sup></label>
                                            <div class="input-group">
                                                <input type="text" name="tb" class="form-control" placeholder="'150' atau '170'" aria-label="Recipient's username" aria-describedby="basic-addon13" value="{{$siswa->tb}}/>
                                                <span class="input-group-text" id="basic-addon13">CM</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Berat Badan:  <sup style="color:red">*</sup></label>
                                                <div class="input-group">
                                                    <input type="text" name="bb" class="form-control" placeholder="'40'atau'37'" aria-label="Recipient's username" aria-describedby="basic-addon13" value="{{$siswa->tt}}/>
                                                    <span class="input-group-text" id="basic-addon13">KG</span>
                                                </div>
                                        
                                        <div class="form-group">
                                            <label for="">Hobi <sup style="color:red">*</sup>label>
                                            <input type="text" id="" name="hobi" class="form-control" placeholder="masukan hobi"value="{{$siswa->hobi}}>
                                        </div>
                                        <div class="form-group">
                                            <label for="">cita-cita: <sup style="color:red">*</sup></label>
                                            <input type="text" id="" name="citacita" class="form-control" placeholder="masukan cita cita"value="{{$siswa->citacita}}>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Tahun Masuk:  <sup style="color:red">*</sup></label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon13">Tahun</span>
                                                <input type="text" name="thn_msk" class="form-control" placeholder="'2020' atau '2021" aria-label="Recipient's username" aria-describedby="basic-addon13" value="{{$siswa->thn_msk}}/>
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

