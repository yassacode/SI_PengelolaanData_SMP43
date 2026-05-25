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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="sakit">Riwayat Sakit:</label>
                                    <textarea id="sakit" name="sakit" class="form-control" rows="2"
                                        placeholder="Masukan riwayat sakit (opsional)">{{ old('sakit', $siswa->kesehatan->riwayat_sakit ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5 class="mb-3">Prestasi Siswa (Opsional)</h5>
                        @for ($i = 1; $i <= 3; $i++)
                            @php
                                $prestasi = $siswa->prestasis->get($i - 1);
                            @endphp
                            <div class="row mb-3">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="kegiatan{{ $i }}">Kegiatan {{ $i }}:</label>
                                        <input type="text" id="kegiatan{{ $i }}" name="kegiatan{{ $i }}" class="form-control"
                                            placeholder="Contoh: Lomba Matematika"
                                            value="{{ old('kegiatan' . $i, $prestasi->kegiatan ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="juara{{ $i }}">Juara Ke-:</label>
                                        <input type="text" id="juara{{ $i }}" name="juara{{ $i }}" class="form-control"
                                            placeholder="Contoh: 1 / Harapan 1"
                                            value="{{ old('juara' . $i, $prestasi->juara ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        @endfor

                        <hr>
                        <h5 class="mb-3">Ekstrakurikuler yang Diikuti</h5>
                        <div class="row">
                            @foreach($masterEkskuls as $ekskul)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="master_ekskul_ids[]" 
                                            value="{{ $ekskul->id }}" id="ekskul_{{ $ekskul->id }}"
                                            {{ in_array($ekskul->id, old('master_ekskul_ids', $siswa->masterEkskuls->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ekskul_{{ $ekskul->id }}">
                                            {{ $ekskul->nama }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
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
