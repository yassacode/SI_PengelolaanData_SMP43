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
                            <form action="{{ route('siswa.update2',$siswa->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="">Asal Paud:</label>
                                    <input type="text" id="" name="asal_paud" class="form-control" placeholder="masukan asal paud siswa"value="{{$siswa->school->asal_paud}}>
                                </div>
                                <div class="form-group">
                                    <label for="">Asal TK:</label>
                                    <input type="text" id="" name="asal_tk" class="form-control" placeholder="masukan asal tk siswa"value="{{$siswa->school->asal_tk}}">
                                </div>
                                <div class="form-group">
                                    <label for="">Asal SD: <sup style="color:red">*</sup></label>
                                    <input type="text" id="" name="asal_sd" class="form-control"placeholder="masukan asal sd siswa"value="{{$siswa->school->asal_sd}}">
                                </div>
                                 <div class="form-group">
                                    <label for="">Jarak rumah ke sekolah: <sup style="color:red">*</sup> </label>
                                    <div class="input-group">
                                        <input type="text" name="jrk_sklh" class="form-control" placeholder="jarak rumah ke sekolah" aria-label="Recipient's username" aria-describedby="basic-addon13"value=" {{$siswa->school->jrk_sklh}}">
                                        <span class="input-group-text" id="basic-addon13">KM</span>
                                    </div>
                                  </div>
                                
                                <div class="form-group">
                                    <label for="">Riwayat Sakit:</label>
                                    <input type="text" id="" name="sakit" class="form-control"placeholder="masukan riwayat sakit kalau ada"value="{{$siswa->history->sakit}}">
                                </div>
                                <div class="form-group">
                                    <label for="">Riwayat Beasiswa:</label>
                                    <input type="text" id="" name="beasiswa" class="form-control" placeholder="masukan riwayat beasiswa kalau ada"value="{{$siswa->history->beasiswa}}">
                                </div>
                                <div class="form-group">
                                    <label for="">Jumlah Saudara: <sup style="color:red">*</sup></label>
                                    <input type="text" id="" name="jumlah" class="form-control"placeholder="jumlah saudara kandung, contoh: '1', '2'"value="{{$siswa->sibling->jumlah}}">
                                </div>
                                    <div class="input-group mt-2">
                                     <span class="input-group-text" id="basic-addon13">anak ke- <sup style="color:red">*</sup></span>
                                     <input type="text" name="jrk_sklh" class="form-control" placeholder="'1' atau '2'" aria-label="Recipient's username" aria-describedby="basic-addon13"value="{{$siswa->sibling->anak_ke}}" >
                                    </div>
                                <div class="form-group">
                                    <label for="">lomba yang pernah diikuti:</label>
                                    <input type="text" id="" name="kegiatan1" class="form-control" placeholder="masukan perlombaan yang pernah diikuti"value="{{$siswa->achievement->kegiatan1}}">
                                </div>
                                <div class="input-group mt-2">
                                 <span class="input-group-text" id="basic-addon13">Juara ke-</span>
                                 <input type="text" name="juara1" class="form-control" placeholder="contoh: '1','2'" aria-label="Recipient's username" aria-describedby="basic-addon13"value="{{$siswa->achievement->juara1}}" >
                                </div>
                              </div>
                             <div class="col-md-6">
                                
                                <div class="form-group">
                                    <label for="">lomba yang pernah diikuti:</label>
                                    <input type="text" id="" name="kegiatan2" class="form-control" placeholder="masukan perlombaan yang pernah diikuti"value="{{$siswa->achievement->kegiatan2}}">
                                </div>
                                <div class="input-group mt-2">
                                 <span class="input-group-text" id="basic-addon13">Juara ke-</span>
                                 <input type="text" name="juara2" class="form-control" placeholder="contoh: '1','2'" aria-label="Recipient's username" aria-describedby="basic-addon13"value="{{$siswa->achievement->juara2}}" >
                                </div>
                                <div class="form-group">
                                    <label for="">lomba yang pernah diikuti:</label>
                                    <input type="text" id="" name="kegiatan3" class="form-control" placeholder="masukan perlombaan yang pernah diikuti"value="{{$siswa->achievement->kegiatan3}}">
                                </div>
                                <div class="input-group mt-2">
                                 <span class="input-group-text" id="basic-addon13">Juara ke-</span>
                                 <input type="text" name="juara3" class="form-control" placeholder="contoh: '1','2'" aria-label="Recipient's username" aria-describedby="basic-addon13"value="{{$siswa->achievement->juara3}}" >
                                </div>
                                <div class="form-group">
                                    <label for="">lomba yang pernah diikuti:</label>
                                    <input type="text" id="" name="kegiatan3" class="form-control" placeholder="masukan perlombaan yang pernah diikuti"value="{{$siswa->achievement->kegiatan4}}">
                                </div>
                                <div class="input-group mt-2">
                                 <span class="input-group-text" id="basic-addon13">Juara ke-</span>
                                 <input type="text" name="juara4" class="form-control" placeholder="contoh: '1','2'" aria-label="Recipient's username" aria-describedby="basic-addon13"value="{{$siswa->achievement->juara4}}" />
                                </div>
                                <div class="form-group">
                                    <label for="">lomba yang pernah diikuti:</label>
                                    <input type="text" id="" name="kegiatan4" class="form-control" placeholder="masukan perlombaan yang pernah diikuti"value="{{$siswa->achievement->kegiatan5}}">
                                </div>
                                <div class="input-group mt-2">
                                 <span class="input-group-text" id="basic-addon13">Juara ke-</span>
                                 <input type="text" name="juara" class="form-control" placeholder="contoh: '1','2'" aria-label="Recipient's username" aria-describedby="basic-addon13"value="{{$siswa->achievement->juara5}}" />
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('siswa.create1') }}" class="btn btn-warning">back</a>
                                    <button type="submit" class="btn btn-primary">next</button>    
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