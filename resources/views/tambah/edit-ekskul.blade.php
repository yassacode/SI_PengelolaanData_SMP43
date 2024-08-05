@extends('base.layout-tambah')
@section('add')
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3>Tambah Kegiatan Ekstrakurikuler</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('ekskul.store') }}" method="POST">
                                @csrf

                            <div class="row">
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="form-label">Nama Extrakurikuler</label>
                                             <select name="ekskul" class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                                              <option selected>...</option>
                                              <option value="Pramuka">Pramuka</option>
                                              <option value="Drumband">Drumband</option>
                                              <option value="Paskibra">Paskibra</option>
                                              <option value="PMR">PMR</option>
                                              <option value="Keagamaan">Keagamaan</option>
                                              <option value="Olahraga">Olahraga</option>
                                             </select>
                                          </div>
                                        <div class="form-group">
                                            <label for="">Nama Kegiatan:</label>
                                            <input type="text" id="" name="kegiatan" class="form-control" value="{{$item->kegiatan}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Lokasi:</label>
                                            <input type="text" id="" name="lokasi" class="form-control" value="{{$item->lokasi}}">
                                        </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name_left">Tanggal Kegiatan:</label>
                                            <input type="date" id="" name="tanggal" class="form-control" value="{{$item->tanggal}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">Foto Kegiatan</label>
                                            <input class="form-control" type="file" id="formFile" name="foto">    
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">Keterangan</label>
                                            <input class="form-control" type="text" id="formFile" name="keterangan" value="{{$item->keterangan}}">    
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary ">Submit</button>
                                        <a href="{{route('ekskul.index')}}" class="btn btn-danger">Cancel</a>
                                    </div>
                            </div>
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>  
       @endsection

