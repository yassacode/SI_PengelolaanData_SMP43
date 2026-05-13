@extends('base.layout')

@section('title', 'Detail Siswa - ' . ($students->nama ?? ''))

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Siswa /</span> Detail Profil
        </h4>
        <div class="d-flex gap-2">
            <a href="{{ url('/siswa') }}" class="btn btn-outline-secondary">
                <i class="bx bx-chevron-left me-1"></i> Kembali
            </a>
            @if (($students->akademik->status ?? null) === 'ACCEPTED')
                <a href="{{ route('siswa.show2', $students->id) }}" target="_blank" class="btn btn-primary">
                    <i class="bx bx-printer me-1"></i> Cetak Biodata
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Sidebar: Foto & Status -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <img class="img-fluid rounded my-4" src="{{ asset('assets/img/avatars/icon.png') }}" height="110" width="110" alt="User avatar" />
                            <div class="user-info text-center">
                                <h4 class="mb-2">{{ $students->nama ?? '-' }}</h4>
                                <span class="badge bg-label-primary">{{ $students->user->nama ?? 'Siswa' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap my-4 py-3">
                        <div class="d-flex align-items-start me-4 mt-3 gap-3">
                            <span class="badge bg-label-primary p-2 rounded"><i class='bx bx-check'></i></span>
                            <div>
                                <h5 class="mb-0">{{ $students->akademik->status ?? 'WAITING' }}</h5>
                                <span>Status</span>
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-2 border-bottom mb-4">Detail Kontak</h5>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <span class="fw-bold me-2">Agama:</span>
                                <span>{{ $students->agama ?? '-' }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Alamat:</span>
                                <span>{{ $students->alamat ?? '-' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Sidebar -->

        <!-- Main Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- Tabs -->
            <div class="nav-tabs-custom mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home">
                            <i class="bx bx-user me-1"></i> Biodata
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile">
                            <i class="bx bx-buildings me-1"></i> Akademik
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-messages">
                            <i class="bx bx-heart me-1"></i> Wali & Kesehatan
                        </button>
                    </li>
                </ul>
                <div class="tab-content card">
                    <!-- Biodata Tab -->
                    <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <p class="form-control-plaintext border-bottom">{{ $students->nama ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tempat/Tanggal Lahir</label>
                                    <p class="form-control-plaintext border-bottom">{{ $students->ttl ?? '-' }}</p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Hobi & Cita-cita</label>
                                    <p class="form-control-plaintext border-bottom">{{ $students->hobi ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Akademik Tab -->
                    <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Asal SD</label>
                                    <p class="form-control-plaintext border-bottom">{{ $students->akademik->asal_sd ?? '-' }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Asal TK</label>
                                    <p class="form-control-plaintext border-bottom">{{ $students->akademik->asal_tk ?? '-' }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Asal PAUD</label>
                                    <p class="form-control-plaintext border-bottom">{{ $students->akademik->asal_paud ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jarak ke Sekolah</label>
                                    <p class="form-control-plaintext border-bottom">{{ $students->akademik->jrk_sklh ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Beasiswa</label>
                                    <p class="form-control-plaintext border-bottom">{{ $students->akademik->beasiswa ?? 'Tidak ada' }}</p>
                                </div>
                            </div>
                            
                            <h6 class="mt-4 fw-bold">Prestasi</h6>
                            <div class="table-responsive">
                                <table class="table table-striped border-top">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kegiatan</th>
                                            <th>Juara</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($students->prestasis as $index => $prestasi)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $prestasi->kegiatan }}</td>
                                                <td>{{ $prestasi->juara }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">Tidak ada data prestasi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Wali & Kesehatan Tab -->
                    <div class="tab-pane fade" id="navs-pills-top-messages" role="tabpanel">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Data Orang Tua</h6>
                            <div class="row mb-4">
                                <div class="col-md-6 border-end">
                                    <p class="fw-bold text-primary mb-2">Ayah</p>
                                    <p class="mb-1"><span class="fw-bold">Nama:</span> {{ $students->wali->nama_ayah ?? '-' }}</p>
                                    <p class="mb-1"><span class="fw-bold">Pekerjaan:</span> {{ $students->wali->pekerjaan_ayah ?? '-' }}</p>
                                    <p class="mb-1"><span class="fw-bold">No. HP:</span> {{ $students->wali->no_hp_ayah ?? '-' }}</p>
                                    <p class="mb-0"><span class="fw-bold">Alamat:</span> {{ $students->wali->alamat_ayah ?? '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="fw-bold text-danger mb-2">Ibu</p>
                                    <p class="mb-1"><span class="fw-bold">Nama:</span> {{ $students->wali->nama_ibu ?? '-' }}</p>
                                    <p class="mb-1"><span class="fw-bold">Pekerjaan:</span> {{ $students->wali->pekerjaan_ibu ?? '-' }}</p>
                                    <p class="mb-1"><span class="fw-bold">No. HP:</span> {{ $students->wali->no_hp_ibu ?? '-' }}</p>
                                    <p class="mb-0"><span class="fw-bold">Alamat:</span> {{ $students->wali->alamat_ibu ?? '-' }}</p>
                                </div>
                            </div>
                            
                            <h6 class="fw-bold mb-2">Data Kesehatan</h6>
                            <div class="alert alert-info d-flex align-items-center mb-0" role="alert">
                                <i class="bx bx-plus-medical me-2"></i>
                                <div>
                                    <span class="fw-bold">Riwayat Penyakit:</span> {{ $students->kesehatan->riwayat_sakit ?? 'Tidak ada riwayat penyakit serius.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Main Content -->
    </div>
</div>
@endsection
