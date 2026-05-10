@extends('base.layout')

@section('title','disiplin')
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container-xxl flex-grow-1 container-p-y">
 <div class="card">
    <h4 class="card-header">Tabel Data Disiplin</h4>
    <div class="table-responsive">
      <table class="table card-table">
          <div class="d-flex justify-content-between align-items-center mb-3 px-3">
            <div>
              {{-- @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Guru BK'))
              <a class="btn btn-primary" href="{{ route('disiplin.create')}}"><i class='bx bxs-user-plus' ></i> Tambah</a>
              @endif --}}
            </div>
            <form action="{{ route('disiplin.index') }}" method="GET" class="d-flex">
                <input class="form-control me-2" type="text" name="search" placeholder="Cari nama & masalah" value="{{ request()->input('search') }}">
                <input class="form-control me-2" type="month" name="month" value="{{ request()->input('month') }}">
                <button type="submit" class="btn btn-primary me-2">Cari</button>
                <a href="{{ route('disiplin.export.pdf', ['month' => request('month')]) }}" class="btn btn-danger me-2" title="Export PDF"><i class='bx bxs-file-pdf'></i></a>
                <a href="{{ route('disiplin.export.excel') }}" class="btn btn-success" title="Export Excel"><i class='bx bx-spreadsheet'></i></a>
            </form>
          </div>
        @php
            $user = auth()->user();
            $isAdmin = $user->hasRole('Admin');
            $isKepalaSekolah = $user->hasRole('Kepala Sekolah');
            $isWaka = $user->hasRole('Waka Kesiswaan');
            $isStaff = $user->hasRole('Staff Kesiswaan');
            $isGuruBK = $user->hasRole('Guru BK');
            
            // Roles that can perform manage actions (Add, Edit, Delete)
            $canManage = $isAdmin || $isWaka || $isStaff || $isGuruBK;
            // Roles that can approve/reject status
            $canApprove = $isAdmin || $isWaka;
        @endphp

        <div class="d-flex justify-content-start mb-3 px-3">
            @if ($canManage)
                <a href="{{ route('disiplin.create') }}" class="me-2">
                    <button type="button" class="btn btn-primary" title="Tambah Data"><i class='bx bxs-user-plus'></i></button>
                </a>
            @endif
            
            @if ($isAdmin || $isWaka || $isStaff)
                <a href="{{ route('disiplin.show', ['month' => request('month')]) }}" class="me-2">
                    <button type="button" class="btn btn-info" title="Cetak"><i class='bx bx-printer'></i></button>
                </a>
            @endif

            @if ($isWaka)
                <a href="{{ route('validasi.disiplin.index') }}" class="me-2">
                    <button type="button" class="btn btn-warning" title="Lihat Validasi">Lihat Validasi</button>
                </a>
            @endif
        </div>

        <thead>
            <tr>
                <th>No</th>
                <th>Pelapor</th>
                <th>Nama Siswa</th>
                <th>Masalah</th>
                <th>Tanggal</th>
                <th>Foto</th>
                <th>Validasi</th>
                @if (!$isKepalaSekolah)
                    <th>Action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($disiplin as $dicipline)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dicipline->pelapor->nama ?? ($dicipline->user->nama ?? '-') }}</td>
                    <td>{{ $dicipline->siswa->nama ?? '-' }}</td>
                    <td>{{ $dicipline->masalah ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($dicipline->tanggal)->locale('id')->translatedFormat('l, d F Y') }}</td>
                    <td>
                        @if($dicipline->foto)
                            <a href="{{ Storage::url($dicipline->foto) }}" target="_blank">
                                <img src="{{ Storage::url($dicipline->foto) }}" alt="Foto Disiplin" class="img-fluid rounded" width="80">
                            </a>
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>
                    <td>
                        @php 
                            $status = $dicipline->status_validasi;
                            $isPending = in_array($status, ['Pending', 'WAITING']);
                            $isApproved = in_array($status, ['Approved', 'ACCEPTED']);
                            $isRejected = in_array($status, ['Rejected', 'DENIED']);
                        @endphp

                        @if ($isPending && $canApprove)
                            <form action="{{ route('disiplin/update/status.updateStts', $dicipline->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-primary mb-1" value="Approved" name="status">TERIMA</button>
                                <button type="submit" class="btn btn-sm btn-danger" value="Rejected" name="status">TOLAK</button>
                            </form>
                        @else
                            @if ($isApproved)
                                <span class="badge bg-label-success">DITERIMA</span>
                            @elseif ($isRejected)
                                <span class="badge bg-label-danger">DITOLAK</span>
                            @elseif ($isPending)
                                <span class="badge bg-label-warning">MENUNGGU</span>
                            @else
                                <span class="badge bg-label-secondary">TIDAK DIKETAHUI</span>
                            @endif
                        @endif
                    </td>
                    @if (!$isKepalaSekolah)
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    @if ($canManage && !$isApproved)
                                        <a class="dropdown-item" href="{{ route('disiplin.edit', $dicipline->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                    @endif

                                    @if ($isAdmin || $isWaka || ($isStaff && $dicipline->user_id == $user->id))
                                        <form action="{{ route('disiplin.destroy', $dicipline->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
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
                    <td colspan="{{ $isKepalaSekolah ? 7 : 8 }}" class="text-center">Tidak ada data yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

  @endsection



