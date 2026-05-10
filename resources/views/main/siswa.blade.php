@extends('base.layout')
@section('title', 'siswa')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h4 class="card-header">Tabel Data Siswa</h4>

            <div class="ms-2 mb-2">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <form action="{{ route('siswa.index') }}" method="GET" class="d-flex pe-3">
                        <input class="form-control me-2" type="text" name="search" placeholder="Cari Nama Siswa"
                            value="{{ request()->input('search') }}">

                        <select name="tahun" class="form-select me-2" style="width: 150px;">
                            <option value="">Semua Tahun</option>
                            @foreach ($years as $y)
                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                    {{ $y }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary me-2">Cari</button>

                        <a href="{{ route('siswa.export.pdf', ['tahun' => request('tahun')]) }}" class="btn btn-danger me-2"
                            title="Export PDF"><i class='bx bxs-file-pdf'></i></a>
                        <a href="{{ route('siswa.export.excel', ['tahun' => request('tahun')]) }}" class="btn btn-success"
                            title="Export Excel"><i class='bx bx-spreadsheet'></i></a>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table card-table">

                        @php
                            $user = auth()->user();
                            $isAdmin = $user->hasRole('Admin');
                            $isKepalaSekolah = $user->hasRole('Kepala Sekolah');
                            $isWaka = $user->hasRole('Waka Kesiswaan');
                            $isStaff = $user->hasRole('Staff Kesiswaan');

                            // Roles that can perform actions (Add, Edit, Delete)
                            $canManage = $isAdmin || $isWaka || $isStaff;
                            // Roles that can approve/reject status
                            $canApprove = $isAdmin || $isWaka;
                        @endphp

                        @if ($canManage)
                            <div class="mb-3">
                                <a class="btn btn-primary" href="{{ route('siswa.create1') }}">
                                    <i class='bx bxs-user-plus'></i> Tambah Siswa
                                </a>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table card-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NISN</th>
                                        <th>Tahun Masuk</th>
                                        <th>User</th>
                                        <th>Status</th>
                                        @if (!$isKepalaSekolah)
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($siswa as $students)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $students->nama ?? '-' }}</td>
                                            <td>{{ $students->nisn ?? '-' }}</td>
                                            <td>{{ $students->thn_msk ?? '-' }}</td>
                                            <td>{{ $students->user->nama ?? '-' }}</td>
                                            <td>
                                                @php $status = $students->akademik->status ?? null; @endphp

                                                @if ($status == 'WAITING' && $canApprove)
                                                    <form
                                                        action="{{ route('siswa/update/status.updateStts', $students->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-primary"
                                                            value="ACCEPTED" name="status">TERIMA</button>
                                                        <button type="submit" class="btn btn-sm btn-danger" value="DENIED"
                                                            name="status">TOLAK</button>
                                                    </form>
                                                @else
                                                    @switch($status)
                                                        @case('WAITING')
                                                            <span class="badge bg-label-warning">MENUNGGU</span>
                                                        @break

                                                        @case('ACCEPTED')
                                                            <span class="badge bg-label-success">DITERIMA</span>
                                                        @break

                                                        @case('DENIED')
                                                            <span class="badge bg-label-danger">DITOLAK</span>
                                                        @break

                                                        @default
                                                            <span class="badge bg-label-secondary">TIDAK DIKETAHUI</span>
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
                                                            <a class="dropdown-item"
                                                                href="{{ route('siswa.show1', $students->id) }}">
                                                                <i class="bx bxs-show me-1"></i> View
                                                            </a>

                                                            @if ($canManage && $status !== 'ACCEPTED')
                                                                <a class="dropdown-item"
                                                                    href="{{ route('siswa.edit1', $students->id) }}">
                                                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                                                </a>
                                                            @endif

                                                            @if ($isAdmin || $isWaka)
                                                                <form action="{{ route('siswa.destroy', $students->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item text-danger">
                                                                        <i class="bx bx-trash me-1"></i> Delete
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="{{ $isKepalaSekolah ? 6 : 7 }}" class="text-center">Tidak ada data
                                                    yang ditemukan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
