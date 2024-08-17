@extends('base.layout-tambah')
@section('title','add disiplin')
@section('add')
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>Tambah Data Kedisiplinan Siswa</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('disiplin.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                             <div class="row">
                                 <div class="col-md-6">
                                        <div class="form-group ">
                                            <label for="student_id">Nama Siswa:</label>
                                                <select name="student_id" id="student_id" class="form-select">
                                                    <option selected>...</option>
                                                    @foreach ($siswa as $student)
                                                        <option value="{{ $student->id }}">{{ $student->nama }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Kelas:</label>
                                            <input type="text" id="" name="kelas" class="form-control" placeholder="Masukan nama kelas, contoh: 7 1">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Bentuk Pelanggaran:</label>
                                            <input type="text" id="" name="masalah" class="form-control" placeholder="Masukan pelanggaran yang dilakukan, contohnya: bolos">
                                        </div>
                                        <div class="form-group">
                                            <label for=""> solusi</label>
                                            <input type="text" id="" name="solusi" class="form-control" placeholder="masukan solusi atau sanksi akibat pelanggaran yang dilakukan">
                                        </div>
                                        
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tanggal Kejadian:</label>
                                            <input type="date" id="" name="tanggal" class="form-control" placeholder="masukan tanggal kejadian pelanggaran">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Fotu Bukti:</label>
                                            <input type="file" id="" name="foto" class="form-control" placeholder="masukan foto bukti">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Keterangan:</label>
                                            <input type="text" id="" name="keterangan" class="form-control">
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-danger">Cancel</button>
                                        </div>    
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
       @endsection

