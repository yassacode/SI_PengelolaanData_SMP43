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
                            <form action="{{ route('siswa.store2') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">Asal Paud:</label>
                                    <input type="text" id="" name="asal_paud" class="form-control" placeholder="masukan asal paud siswa">
                                </div>
                                <div class="form-group">
                                    <label for="">Asal TK:</label>
                                    <input type="text" id="" name="asal_tk" class="form-control" placeholder="masukan asal tk siswa">
                                </div>
                                <div class="form-group">
                                    <label for="">Asal SD:</label>
                                    <input type="text" id="" name="asal_sd" class="form-control"placeholder="masukan asal sd siswa">
                                </div>
                                <div class="form-group">
                                    <label for="">Jarak Rumah Ke Sekolah:</label>
                                    <input type="text" id="" name="jrk_sklh" class="form-control"placeholder="masukan hanya angka dalam satuan KM">
                                </div>
                                <div class="form-group">
                                    <label for="">Riwayat Sakit:</label>
                                    <input type="text" id="" name="sakit" class="form-control"placeholder="masukan riwayat sakit kalau ada">
                                </div>
                              </div>
                             <div class="col-md-6">
                            
                                <div class="form-group">
                                    <label for="">Riwayat Beasiswa:</label>
                                    <input type="text" id="" name="beasiswa" class="form-control" placeholder="masukan riwayat beasiswa kalau ada">
                                </div>
                                <div class="form-group">
                                    <label for="">Pernah Ikut Perlombaan Apa:</label>
                                    <input type="text" id="" name="kegiatan" class="form-control" placeholder="masukan perlombaan yang pernah diikuti">
                                </div>
                                <div class="form-group">
                                    <label for="">Dan Juara Berapa:</label>
                                    <input type="text" id="" name="juara" class="form-control" placeholder="juara ke berapa??">
                                </div>
                                <div class="form-group">
                                    <label for="">Jumlah Saudara:</label>
                                    <input type="text" id="" name="jumlah" class="form-control"placeholder="jumlah saudara kandung">
                                </div>
                                <div class="form-group">
                                    <label for="">Anak Ke-:</label>
                                    <input type="text" id="" name="anak_ke" class="form-control"placeholder="anak ke-">
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