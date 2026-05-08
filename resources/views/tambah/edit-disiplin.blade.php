@extends('base.layout-tambah')
@section('add')
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>Tambah Data Kedisiplinan Siswa</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('disiplin.update',$disiplin->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
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
                                            <input type="text" id="" name="kelas" class="form-control" value="{{$disiplin->kelas}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Bentuk Pelanggaran:</label>
                                            <input type="text" id="" name="masalah" class="form-control" value="{{$disiplin->masalah}}">
                                        </div>
                                        <div class="form-group">
                                            <label for=""> solusi</label>
                                            <input type="text" id="" name="solusi" class="form-control" value="{{$disiplin->solusi}}">
                                        </div>
                                        
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tanggal Kejadian:</label>
                                            <input type="date" id="" name="tanggal" class="form-control" value="{{$disiplin->tanggal}}">
                                        </div>
                                        <div class="form-group">
                                         <!-- Input lain -->
    
                                            <!-- Menampilkan gambar yang sudah ada -->
                                            @if ($disiplin->foto)
                                            <div>
                                                <img src="{{ Storage::url($disiplin->foto) }}" alt="Foto Bukti" style="width: 150px;">
                                            </div>
                                        @endif

                                        <!-- Input untuk unggah gambar baru -->
                                        <div>
                                            <label for="foto">Unggah Foto Baru (Opsional)</label>
                                            <input type="file" name="foto" id="foto">
                                        </div>   
                                        </div>
                                        <div class="form-group">
                                            <label for="">Keterangan:</label>
                                            <input type="text" id="" name="keterangan" class="form-control" value="{{$disiplin->keterangan}}">
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-primary">Update</button>
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





