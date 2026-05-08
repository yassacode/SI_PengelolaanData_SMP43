@extends('base.layout-tambah')
@section('title','Edit Data Siswa - Step 2')
@section('add')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Data Siswa <small class="text-muted">— Step 2: Data Akademik</small></h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('siswa.update2', $siswa->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="asal_paud">Asal PAUD:</label>
                                    <input type="text" id="asal_paud" name="asal_paud" class="form-control" value="{{ old('asal_paud', $siswa->akademik->asal_paud ?? '') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="asal_tk">Asal TK:</label>
                                    <input type="text" id="asal_tk" name="asal_tk" class="form-control" value="{{ old('asal_tk', $siswa->akademik->asal_tk ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="asal_sd">Asal SD: <sup class="text-danger">*</sup></label>
                                    <input type="text" id="asal_sd" name="asal_sd" class="form-control" value="{{ old('asal_sd', $siswa->akademik->asal_sd ?? '') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="beasiswa">Riwayat Beasiswa:</label>
                                    <input type="text" id="beasiswa" name="beasiswa" class="form-control" value="{{ old('beasiswa', $siswa->akademik->beasiswa ?? '') }}">
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('siswa.edit1', $siswa->id) }}" class="btn btn-warning px-4">← Kembali</a>
                            <button type="submit" class="btn btn-primary px-4">Lanjut →</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
