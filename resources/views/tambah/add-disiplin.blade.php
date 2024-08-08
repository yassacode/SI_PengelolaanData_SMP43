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
                            <form action="{{ route('disiplin.store') }}" method="POST">
                                @csrf>
                             <div class="row">
                                 <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="form-label">Nama siswa</label>
                                            <select name="category" id="category">
                                                @foreach($disiplin as $dicipline)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select> 
                                        </div>
                                        <div class="form-group">
                                            <label for="">Kelas:</label>
                                            <input type="text" id="" name="kelas" class="form-control" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Bentuk Pelanggaran:</label>
                                            <input type="text" id="" name="foto" class="form-control" value="">
                                        </div>
                                        
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tanggal Kejadian:</label>
                                            <input type="text" id="" name="tanggal" class="form-control" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Fotu Bukti:</label>
                                            <input type="text" id="" name="foto" class="form-control" value="">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Keterangan:</label>
                                            <input type="text" id="" name="keterangan" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-danger">Cancel</button>
                                </div>    
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
       @endsection

