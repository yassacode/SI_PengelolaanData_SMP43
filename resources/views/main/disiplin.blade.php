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
              @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Guru BK'))
              <a class="btn btn-primary" href="{{ route('disiplin.create')}}"><i class='bx bxs-user-plus' ></i> Tambah</a>
              @endif
            </div>
            <form action="{{ route('disiplin.index') }}" method="GET" class="d-flex">
                <input class="form-control me-2" type="text" name="search" placeholder="Cari nama & masalah" value="{{ request()->input('search') }}">
                <input class="form-control me-2" type="month" name="month" value="{{ request()->input('month') }}">
                <button type="submit" class="btn btn-primary me-2">Cari</button>
                <a href="{{ route('disiplin.export.pdf', ['month' => request('month')]) }}" class="btn btn-danger me-2" title="Export PDF"><i class='bx bxs-file-pdf'></i></a>
                <a href="{{ route('disiplin.export.excel') }}" class="btn btn-success" title="Export Excel"><i class='bx bx-spreadsheet'></i></a>
            </form>
          </div>
        @if(auth()->user()->hasRole('Admin'))
        <div class="d-flex justify-content-start">
          <a href="{{route('disiplin.create')}}" class="ms-5 ">
              <button type="button" class="btn btn-primary"><i class='bx bxs-user-plus'></i></button>
          </a>
          <a href="{{ route('disiplin.show', ['month' => request()->input('month')]) }}" class="ms-2">
            <button type="button" class="btn btn-info"><i class='bx bx-printer'></i></button>
        </a>
       </div>
       <thead>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama Siswa</th>
            <th>Masalah</th>
            <th>Tanggal</th>
            <th>Foto</th>
            <th>Validasi</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if($disiplin->isEmpty())
            <tr>
                <td colspan="9" class="text-center">Tidak ada data yang ditemukan.</td>
            </tr>
        @else
            @foreach ($disiplin as $dicipline)
            <tr>
                <td scope="row">{{ $loop->iteration }}</td>
                <td>{{ $dicipline->pelapor->nama ?? ($dicipline->user->nama ?? '') }}</td>
                <td>{{ $dicipline->siswa->nama ?? '' }}</td>
                <td>{{ $dicipline->masalah ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($dicipline->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
                <td>
                    @if($dicipline->foto)
                    <a href="{{ Storage::url($dicipline->foto) }}" target="_blank">
                        <img src="{{ Storage::url($dicipline->foto) }}" alt="" class="img img-fluid" width="150" height="150">
                    </a>
                    @else
                    <span>No Image</span>
                    @endif
                </td>
                <td>
                    @if ($dicipline->status_validasi == 'Pending' || $dicipline->status_validasi == 'WAITING')
                    <form action="{{ route('disiplin/update/status.updateStts', $dicipline->id) }}" method="POST" onsubmit="return handleStatusChange(this, '{{ $dicipline->id }}');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-primary" value="ACCEPTED" name="status">TERIMA</button>
                        <button type="submit" class="btn btn-sm btn-danger" value="DENIED" name="status">TOLAK</button>
                    </form>
                    @elseif ($dicipline->status_validasi == 'Approved' || $dicipline->status_validasi == 'ACCEPTED')
                    <span class="badge bg-label-success me-1">DITERIMA</span>
                    @elseif ($dicipline->status_validasi == 'Rejected' || $dicipline->status_validasi == 'DENIED')
                    <span class="badge bg-label-danger me-1">DITOLAK</span>
                    @else
                    <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                    @endif
                </td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                        <div class="dropdown-menu">
                          @if ($dicipline->status_validasi !== 'Approved' && $dicipline->status_validasi !== 'ACCEPTED')
                            <a class="dropdown-item" href="{{ route('disiplin.edit', $dicipline->id) }} "><i class="bx bx-edit-alt me-1"></i>Edit</a>
                            @endif
                            <form action="{{ route('disiplin.destroy', $dicipline->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i>Delete </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
        @elseif(auth()->user()->hasRole('Kepala Sekolah'))
       <thead>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama Siswa</th>
            <th>Masalah</th>
            <th>Tanggal</th>
            <th>Foto</th>
            <th>Validasi</th>
        </tr>
    </thead>
    <tbody>
        @if($disiplin->isEmpty())
            <tr>
                <td colspan="9" class="text-center">Tidak ada data yang ditemukan.</td>
            </tr>
        @else
            @foreach ($disiplin as $dicipline)
            <tr>
                <td scope="row">{{ $loop->iteration }}</td>
                <td>{{ $dicipline->pelapor->nama ?? ($dicipline->user->nama ?? '') }}</td>
                <td>{{ $dicipline->siswa->nama ?? '' }}</td>
                <td>{{ $dicipline->masalah ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($dicipline->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
                <td>
                    @if($dicipline->foto)
                    <a href="{{ Storage::url($dicipline->foto) }}" target="_blank">
                        <img src="{{ Storage::url($dicipline->foto) }}" alt="" class="img img-fluid" width="150" height="150">
                    </a>
                    @else
                    <span>No Image</span>
                    @endif
                </td>
                <td>
                    @if ($dicipline->status_validasi == 'Pending' || $dicipline->status_validasi == 'WAITING')
                    @elseif ($dicipline->status_validasi == 'Approved' || $dicipline->status_validasi == 'ACCEPTED')
                    <span class="badge bg-label-success me-1">DITERIMA</span>
                    @elseif ($dicipline->status_validasi == 'Rejected' || $dicipline->status_validasi == 'DENIED')
                    <span class="badge bg-label-danger me-1">DITOLAK</span>
                    @else
                    <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                    @endif
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
        @elseif(auth()->user()->hasRole('Waka Kesiswaan'))
        <div class="d-flex justify-content-start">
          <a href="{{route('disiplin.create')}}" class="ms-5 ">
              <button type="button" class="btn btn-primary"><i class='bx bxs-user-plus'></i></button>
          </a>
          <a href="{{route('disiplin.show', ['month' => request('month')])}}" class="ms-2">
              <button type="button" class="btn btn-info" title="Cetak"><i class='bx bx-printer'></i></button>
          </a>
          <a href="{{route('validasi.disiplin.index')}}" class="ms-2">
              <button type="button" class="btn btn-warning" title="Lihat Validasi">Lihat Validasi</button>
          </a>
       </div>
       <thead>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama Siswa</th>
            <th>Masalah</th>
            <th>Tanggal</th>
            <th>Foto</th>
            <th>Validasi</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if($disiplin->isEmpty())
            <tr>
                <td colspan="9" class="text-center">Tidak ada data yang ditemukan.</td>
            </tr>
        @else
            @foreach ($disiplin as $dicipline)
            <tr>
                <td scope="row">{{ $loop->iteration }}</td>
                <td>{{ $dicipline->pelapor->nama ?? ($dicipline->user->nama ?? '') }}</td>
                <td>{{ $dicipline->siswa->nama ?? '' }}</td>
                <td>{{ $dicipline->masalah ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($dicipline->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
                <td>
                    @if($dicipline->foto)
                    <a href="{{ Storage::url($dicipline->foto) }}" target="_blank">
                        <img src="{{ Storage::url($dicipline->foto) }}" alt="" class="img img-fluid" width="150" height="150">
                    </a>
                    @else
                    <span>No Image</span>
                    @endif
                </td>
                <td>
                    @if ($dicipline->status_validasi == 'Pending' || $dicipline->status_validasi == 'WAITING')
                    <form action="{{ route('disiplin/update/status.updateStts', $dicipline->id) }}" method="POST" onsubmit="return handleStatusChange(this, '{{ $dicipline->id }}');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-primary" value="ACCEPTED" name="status">TERIMA</button>
                        <button type="submit" class="btn btn-sm btn-danger" value="DENIED" name="status">TOLAK</button>
                    </form>
                    @elseif ($dicipline->status_validasi == 'Approved' || $dicipline->status_validasi == 'ACCEPTED')
                    <span class="badge bg-label-success me-1">DITERIMA</span>
                    @elseif ($dicipline->status_validasi == 'Rejected' || $dicipline->status_validasi == 'DENIED')
                    <span class="badge bg-label-danger me-1">DITOLAK</span>
                    @else
                    <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                    @endif
                </td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                        <div class="dropdown-menu">
                          @if ($dicipline->status_validasi !== 'Approved' && $dicipline->status_validasi !== 'ACCEPTED')
                            <a class="dropdown-item" href="{{ route('disiplin.edit', $dicipline->id) }} "><i class="bx bx-edit-alt me-1"></i>Edit</a>
                            @endif
                            <form action="{{ route('disiplin.destroy', $dicipline->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i>Delete </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
        @elseif(auth()->user()->hasRole('Staff Kesiswaan'))
        <div class="d-flex justify-content-start">
          <a href="{{route('disiplin.create')}}" class="ms-5 ">
              <button type="button" class="btn btn-primary"><i class='bx bxs-user-plus'></i></button>
          </a>
          <a href="{{route('disiplin.show')}}" class="ms-2">
              <button type="button" class="btn btn-info"><i class='bx bx-printer'></i></button>
          </a>
       </div>
       <thead>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama Siswa</th>
            <th>Masalah</th>
            <th>Tanggal</th>
            <th>Foto</th>
            <th>Validasi</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if($disiplin->isEmpty())
            <tr>
                <td colspan="9" class="text-center">Tidak ada data yang ditemukan.</td>
            </tr>
        @else
            @foreach ($disiplin as $dicipline)
            <tr>
                <td scope="row">{{ $loop->iteration }}</td>
                <td>{{ $dicipline->pelapor->nama ?? ($dicipline->user->nama ?? '') }}</td>
                <td>{{ $dicipline->siswa->nama ?? '' }}</td>
                <td>{{ $dicipline->masalah ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($dicipline->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
                <td>
                    @if($dicipline->foto)
                    <a href="{{ Storage::url($dicipline->foto) }}" target="_blank">
                        <img src="{{ Storage::url($dicipline->foto) }}" alt="" class="img img-fluid" width="150" height="150">
                    </a>
                    @else
                    <span>No Image</span>
                    @endif
                </td>
                <td>
                    @if ($dicipline->status_validasi == 'Pending' || $dicipline->status_validasi == 'WAITING')
                    <span class="badge bg-label-warning me-1">MENUNGGU</span>
                  @elseif ($dicipline->status_validasi == 'Approved' || $dicipline->status_validasi == 'ACCEPTED')
                    <span class="badge bg-label-success me-1">DITERIMA</span>
                  @elseif ($dicipline->status_validasi == 'Rejected' || $dicipline->status_validasi == 'DENIED')
                    <span class="badge bg-label-danger me-1">DITOLAK</span>
                  @else
                    <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                  @endif
                </td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                        <div class="dropdown-menu">
                          @if ($dicipline->status_validasi !== 'Approved' && $dicipline->status_validasi !== 'ACCEPTED')
                            <a class="dropdown-item" href="{{ route('disiplin.edit', $dicipline->id) }} "><i class="bx bx-edit-alt me-1"></i>Edit</a>
                            @endif
                            <form action="{{ route('disiplin.destroy', $dicipline->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i>Delete </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
        @else
        <div class="d-flex justify-content-start">
          <a href="{{route('disiplin.create')}}" class="ms-5 ">
              <button type="button" class="btn btn-primary"><i class='bx bxs-user-plus'></i></button>
          </a>
       </div>
       <thead>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama Siswa</th>
            <th>Masalah</th>
            <th>Tanggal</th>
            <th>Foto</th>
            <th>Validasi</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if($disiplin->isEmpty())
            <tr>
                <td colspan="9" class="text-center">Tidak ada data yang ditemukan.</td>
            </tr>
        @else
            @foreach ($disiplin as $dicipline)
            <tr>
                <td scope="row">{{ $loop->iteration }}</td>
                <td>{{ $dicipline->pelapor->nama ?? ($dicipline->user->nama ?? '') }}</td>
                <td>{{ $dicipline->siswa->nama ?? '' }}</td>
                <td>{{ $dicipline->masalah ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($dicipline->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
                <td>
                    @if($dicipline->foto)
                    <a href="{{ Storage::url($dicipline->foto) }}" target="_blank">
                        <img src="{{ Storage::url($dicipline->foto) }}" alt="" class="img img-fluid" width="150" height="150">
                    </a>
                    @else
                    <span>No Image</span>
                    @endif
                </td>
                <td>
                    @if ($dicipline->status_validasi == 'Pending' || $dicipline->status_validasi == 'WAITING')
                      <span class="badge bg-label-warning me-1">MENUNGGU</span>
                    @elseif ($dicipline->status_validasi == 'Approved' || $dicipline->status_validasi == 'ACCEPTED')
                      <span class="badge bg-label-success me-1">DITERIMA</span>
                    @elseif ($dicipline->status_validasi == 'Rejected' || $dicipline->status_validasi == 'DENIED')
                      <span class="badge bg-label-danger me-1">DITOLAK</span>
                    @else
                      <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                    @endif
                </td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                        <div class="dropdown-menu">
                          @if ($dicipline->status_validasi !== 'Approved' && $dicipline->status_validasi !== 'ACCEPTED')
                            <a class="dropdown-item" href="{{ route('disiplin.edit', $dicipline->id) }} "><i class="bx bx-edit-alt me-1"></i>Edit</a>
                            @endif
                            <form action="{{ route('disiplin.destroy', $dicipline->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i>Delete </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        @endif
    </tbody>
        @endif
      </table>
    </div>
  </div>
</div>

  @endsection



