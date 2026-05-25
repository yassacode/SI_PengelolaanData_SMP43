@extends('base.layout')
@section('title', 'ekskul')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h4 class="card-header">Tabel Data Kegiatan Ekstrakurikuler</h4>
            <div class="table-responsive">
                <table class="table card-table">
                    <div class="d-flex justify-content-between align-items-center mb-3 px-3">
                        <form action="{{ route('ekskul.index') }}" method="GET" class="d-flex">
                            <input class="form-control me-2" type="text" name="search" placeholder="Cari ekskul"
                                value="{{ request()->input('search') }}">
                            <input class="form-control me-2" type="month" name="month"
                                value="{{ request()->input('month') }}">
                            <button type="submit" class="btn btn-primary me-2">Cari</button>
                            <a href="{{ route('ekskul.export.pdf', ['month' => request('month')]) }}"
                                class="btn btn-danger me-2" title="Export PDF"><i class='bx bxs-file-pdf'></i></a>
                            <a href="{{ route('ekskul.export.excel') }}" class="btn btn-success" title="Export Excel"><i
                                    class='bx bx-spreadsheet'></i></a>
                        </form>
                    </div>
                    @php
                        $user = auth()->user();
                        $isAdmin = $user->hasRole('Admin');
                        $isKepalaSekolah = $user->hasRole('Kepala Sekolah');
                        $isWaka = $user->hasRole('Waka Kesiswaan');
                        $isStaff = $user->hasRole('Staff Kesiswaan');
                        $isGuru = $user->hasRole('Guru'); // Pembina

                        // Roles that can manage (Add, Edit, Delete)
                        $canManage = $isAdmin || $isWaka || $isStaff || $isGuru;
                    @endphp

                    <div class="d-flex justify-content-start mb-3 px-3">
                        @if ($canManage)
                            <a href="{{ route('ekskul.create') }}" class="me-2">
                                <button type="button" class="btn btn-primary" title="Tambah Kegiatan"><i
                                        class='bx bxs-user-plus'></i></button>
                            </a>
                        @endif

                        @if ($isAdmin || $isWaka || $isStaff)
                            <a href="{{ route('ekskul.show', ['month' => request('month')]) }}" class="me-2">
                                <button type="button" class="btn btn-info" title="Cetak"><i
                                        class='bx bx-printer'></i></button>
                            </a>
                        @endif
                    </div>

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pembina</th>
                            <th>Nama Ekskul</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Foto</th>
                            <th>keterangan</th>
                            <th>Validasi</th>
                            @if (!$isKepalaSekolah)
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->pembina->nama ?? ($item->user->nama ?? '-') }}</td>
                                <td>{{ $item->masterEkskul->nama ?? '-' }}</td>
                                <td>{{ $item->nama_kegiatan ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') }}
                                </td>
                                <td>{{ $item->lokasi ?? '-' }}</td>
                                <td>
                                    @if ($item->foto)
                                        <a href="{{ Storage::url($item->foto) }}" target="_blank">
                                            <img src="{{ Storage::url($item->foto) }}" alt="Foto Kegiatan"
                                                class="img-fluid rounded" width="80">
                                        </a>
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ $item->keterangan ?? '-' }}
                                </td>
                                <td>
                                    @php
                                        $status = $item->status_validasi ?? 'Pending';
                                        $canApprove = $isAdmin || $isWaka;
                                    @endphp

                                    @if ($status == 'Pending' && $canApprove)
                                        <form action="{{ route('ekskul/update/status.updateStts', $item->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-primary mb-1" value="Approved"
                                                name="status">TERIMA</button>
                                            <button type="submit" class="btn btn-sm btn-danger" value="Rejected"
                                                name="status">TOLAK</button>
                                        </form>
                                    @else
                                        @switch($status)
                                            @case('Approved')
                                                <span class="badge bg-label-success">DITERIMA</span>
                                            @break

                                            @case('Rejected')
                                                <span class="badge bg-label-danger">DITOLAK</span>
                                            @break

                                            @default
                                                <span class="badge bg-label-warning">MENUNGGU</span>
                                        @endswitch
                                    @endif
                                </td>
                                @if (!$isKepalaSekolah)
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @if ($isAdmin || $isWaka || $item->user_id == $user->id)
                                                    <a class="dropdown-item" href="{{ route('ekskul.edit', $item->id) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>

                                                    <form action="{{ route('ekskul.destroy', $item->id) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="dropdown-item disabled text-muted">No Access</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $isKepalaSekolah ? 6 : 7 }}" class="text-center">Tidak ada data yang
                                        ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
