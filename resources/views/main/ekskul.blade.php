@extends('base.layout')
@section('title','ekskul')

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
        <div class="d-flex justify-content-end me-3">
          <form action="{{ route('ekskul.index') }}" method="GET">
              <input class="me-2" type="text" name="search" placeholder="cari ekskul" value="{{ request()->input('search') }}">
              <input class="me-2" type="month" name="month" value="{{ request()->input('month') }}">
              <button type="submit" class="btn btn-primary">Cari</button>
          </form>
      </div>
        @if(auth()->user()->level == 'admin')
        <div class="d-flex justify-content-start">
          <a href="{{route('ekskul.create')}}" class="ms-5 ">
              <button type="button" class="btn btn-primary"><i class='bx bxs-user-plus'></i></button>
          </a>
          <a href="{{ route('ekskul.show', ['month' => request()->input('month')]) }}" class="ms-2">
            <button type="button" class="btn btn-info"><i class='bx bx-printer'></i></button>
        </a>
       </div>
        <thead>
          <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama Ekstrakurikuler</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Foto</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @if($data->isEmpty())
          <tr>
              <td colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
          </tr>
          @else
          @foreach ($data as $item)  
          <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{ $item->user->name ?? '' }}</td>
            <td>{{ $item->ekskul ?? '' }}</td>
            <td>{{ $item->kegiatan ?? '' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
            <td>{{ $item->lokasi ?? '' }}</td>
            <td>
              @if($item->foto)
              <a href="{{ Storage::url($item->foto) }}" target="_blank">
                <img src="{{ Storage::url($item->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150"></td>
              </a>
               @else
              <span>No Image</span>
              @endif
            </td>
            <td>{{ $item->keterangan ?? '' }}</td>
             <td>
                    @if ($item->status == 'WAITING')
                    <form action="{{ route('ekskul/update/status.updateStts', $item->id) }}" method="POST" onsubmit="return handleStatusChange(this, '{{ $item->id }}');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-primary" value="ACCEPTED" name="status">TERIMA</button>
                        <button type="submit" class="btn btn-sm btn-danger" value="DENIED" name="status">TOLAK</button>
                    </form>
                    @elseif ($item->status == 'ACCEPTED')
                    <span class="badge bg-label-success me-1">DITERIMA</span>
                    @elseif ($item->status == 'DENIED')
                    <span class="badge bg-label-danger me-1">DITOLAK</span>
                    @else
                    <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                    @endif
                </td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('ekskul.edit', $item->id) }} "><i class="bx bx-edit-alt me-1"></i>Edit</a>
                  <form action="{{ route('ekskul.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i>Delete </button>
                  </form>
              </div>
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>
        @elseif(auth()->user()->level == 'kepala sekolah')
        <thead>
          <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama Ekstrakurikuler</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Foto</th>
            <th>Keterangan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @if($data->isEmpty())
          <tr>
              <td colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
          </tr>
          @else
          @foreach ($data as $item)  
          <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{ $item->user_id ?? '' }}</td>
            <td>{{ $item->ekskul ?? '' }}</td>
            <td>{{ $item->kegiatan ?? '' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
            <td>{{ $item->lokasi ?? '' }}</td>
            <td>
              @if($item->foto)
              <a href="{{ Storage::url($item->foto) }}" target="_blank">
                <img src="{{ Storage::url($item->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150"></td>
              </a>
               @else
              <span>No Image</span>
              @endif
            </td>
            <td>{{ $item->keterangan ?? '' }}</td>
             <td>
                    @if ($item->status == 'WAITING')
                    @elseif ($item->status == 'ACCEPTED')
                    <span class="badge bg-label-success me-1">DITERIMA</span>
                    @elseif ($item->status == 'DENIED')
                    <span class="badge bg-label-danger me-1">DITOLAK</span>
                    @else
                    <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                    @endif
                </td>
          </tr>
          @endforeach
          @endif
        </tbody>
        @elseif(auth()->user()->level == 'waka kesiswaan')
          <div class="d-flex justify-content-start">
            <a href="{{route('ekskul.create')}}" class="ms-5 ">
                <button type="button" class="btn btn-primary"><i class='bx bxs-user-plus'></i></button>
            </a>
            <a href="{{ route('ekskul.show', ['month' => request()->input('month')]) }}" class="ms-2">
              <button type="button" class="btn btn-info"><i class='bx bx-printer'></i></button>
            </a>
          </div>
        <thead>
          <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama Ekstrakurikuler</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Foto</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @if($data->isEmpty())
          <tr>
              <td colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
          </tr>
          @else
          @foreach ($data as $item)  
          <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{ $item->user_id ?? '' }}</td>
            <td>{{ $item->ekskul ?? '' }}</td>
            <td>{{ $item->kegiatan ?? '' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
            <td>{{ $item->lokasi ?? '' }}</td>
            <td>
              @if($item->foto)
              <a href="{{ Storage::url($item->foto) }}" target="_blank">
                <img src="{{ Storage::url($item->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150"></td>
              </a>
               @else
              <span>No Image</span>
              @endif
            </td>
            <td>{{ $item->keterangan ?? '' }}</td>
             <td>
                    @if ($item->status == 'WAITING')
                    <form action="{{ route('ekskul/update/status.updateStts', $item->id) }}" method="POST" onsubmit="return handleStatusChange(this, '{{ $item->id }}');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-primary" value="ACCEPTED" name="status">TERIMA</button>
                        <button type="submit" class="btn btn-sm btn-danger" value="DENIED" name="status">TOLAK</button>
                    </form>
                    @elseif ($item->status == 'ACCEPTED')
                    <span class="badge bg-label-success me-1">DITERIMA</span>
                    @elseif ($item->status == 'DENIED')
                    <span class="badge bg-label-danger me-1">DITOLAK</span>
                    @else
                    <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                    @endif
                </td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('ekskul.edit', $item->id) }} "><i class="bx bx-edit-alt me-1"></i>Edit</a>
                  <form action="{{ route('ekskul.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i>Delete </button>
                  </form>
              </div>
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>
        @elseif(auth()->user()->level == 'staff waka kesiswaan')
        <div class="d-flex justify-content-start">
          <a href="{{route('ekskul.create')}}" class="ms-5 ">
              <button type="button" class="btn btn-primary"><i class='bx bxs-user-plus'></i></button>
          </a>
          <a href="{{ route('ekskul.show', ['month' => request()->input('month')]) }}" class="ms-2">
            <button type="button" class="btn btn-info"><i class='bx bx-printer'></i></button>
        </a>
       </div>
       <thead>
          <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama Ekstrakurikuler</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Foto</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @if($data->isEmpty())
          <tr>
              <td colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
          </tr>
          @else
          @foreach ($data as $item)  
          <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{ $item->user_id ?? '' }}</td>
            <td>{{ $item->ekskul ?? '' }}</td>
            <td>{{ $item->kegiatan ?? '' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
            <td>{{ $item->lokasi ?? '' }}</td>
            <td>
              @if($item->foto)
              <a href="{{ Storage::url($item->foto) }}" target="_blank">
                <img src="{{ Storage::url($item->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150"></td>
              </a>
               @else
              <span>No Image</span>
              @endif
            </td>
            <td>{{ $item->keterangan ?? '' }}</td>
             <td>
              @if ($item->status == 'WAITING')
              <span class="badge bg-label-warning me-1">WAITING</span>
              @elseif ($item->status == 'ACCEPTED')
              <span class="badge bg-label-success me-1">DITERIMA</span>
              @elseif ($item->status == 'DENIED')
              <span class="badge bg-label-danger me-1">DITOLAK</span>
              @else
              <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
              @endif
                </td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('ekskul.edit', $item->id) }} "><i class="bx bx-edit-alt me-1"></i>Edit</a>
                  <form action="{{ route('ekskul.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i>Delete </button>
                  </form>
              </div>
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>
        @else
        <a class="nav-link" href="{{ route('ekskul.create')}}"><button type="button" class="btn btn-primary"><i class='bx bxs-user-plus' ></i></button></a>
        <thead>
          <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama Ekstrakurikuler</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Foto</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @if($data->isEmpty())
          <tr>
              <td colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
          </tr>
          @else
          @foreach ($data as $item)  
          <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{ $item->user_id ?? '' }}</td>
            <td>{{ $item->ekskul ?? '' }}</td>
            <td>{{ $item->kegiatan ?? '' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
            <td>{{ $item->lokasi ?? '' }}</td>
            <td>
              @if($item->foto)
              <a href="{{ Storage::url($item->foto) }}" target="_blank">
                <img src="{{ Storage::url($item->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150"></td>
              </a>
               @else
              <span>No Image</span>
              @endif
            </td>
            <td>{{ $item->keterangan ?? '' }}</td>
             <td>
                    @if ($item->status == 'WAITING')
                    <span class="badge bg-label-warning me-1">WAITING</span>
                    @elseif ($item->status == 'ACCEPTED')
                    <span class="badge bg-label-success me-1">DITERIMA</span>
                    @elseif ($item->status == 'DENIED')
                    <span class="badge bg-label-danger me-1">DITOLAK</span>
                    @else
                    <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                    @endif
                </td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('ekskul.edit', $item->id) }} "><i class="bx bx-edit-alt me-1"></i>Edit</a>
                  <form action="{{ route('ekskul.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i>Delete </button>
                  </form>
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