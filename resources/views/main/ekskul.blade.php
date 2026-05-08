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
          <div class="d-flex justify-content-between align-items-center mb-3 px-3">
            <div>
              @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Guru'))
              <a class="btn btn-primary" href="{{ route('ekskul.create')}}"><i class='bx bxs-user-plus' ></i> Tambah</a>
              @endif
            </div>
            <form action="{{ route('ekskul.index') }}" method="GET" class="d-flex">
                <input class="form-control me-2" type="text" name="search" placeholder="Cari ekskul" value="{{ request()->input('search') }}">
                <input class="form-control me-2" type="month" name="month" value="{{ request()->input('month') }}">
                <button type="submit" class="btn btn-primary me-2">Cari</button>
                <a href="{{ route('ekskul.export.pdf', ['month' => request('month')]) }}" class="btn btn-danger me-2" title="Export PDF"><i class='bx bxs-file-pdf'></i></a>
                <a href="{{ route('ekskul.export.excel') }}" class="btn btn-success" title="Export Excel"><i class='bx bx-spreadsheet'></i></a>
            </form>
          </div>
        @if(auth()->user()->hasRole('Admin'))
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
            <th>Pembina</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Foto</th>
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
            <td>{{ $item->pembina->nama ?? ($item->user->nama ?? '') }}</td>
            <td>{{ $item->nama_kegiatan ?? '' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
            <td>{{ $item->lokasi ?? '' }}</td>
            <td>
              @if($item->foto)
              <a href="{{ Storage::url($item->foto) }}" target="_blank">
                <img src="{{ Storage::url($item->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150">
              </a>
               @else
              <span>No Image</span>
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
        @elseif(auth()->user()->hasRole('Kepala Sekolah'))
        <thead>
          <tr>
            <th>No</th>
            <th>Pembina</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Foto</th>
          </tr>
        </thead>
        <tbody>
          @if($data->isEmpty())
          <tr>
              <td colspan="6" class="text-center">Tidak ada data yang ditemukan.</td>
          </tr>
          @else
          @foreach ($data as $item)  
          <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{ $item->pembina->nama ?? ($item->user->nama ?? '') }}</td>
            <td>{{ $item->nama_kegiatan ?? '' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
            <td>{{ $item->lokasi ?? '' }}</td>
            <td>
              @if($item->foto)
              <a href="{{ Storage::url($item->foto) }}" target="_blank">
                <img src="{{ Storage::url($item->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150">
              </a>
               @else
              <span>No Image</span>
              @endif
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>
        @elseif(auth()->user()->hasRole('Waka Kesiswaan'))
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
            <th>Pembina</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Foto</th>
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
            <td>{{ $item->pembina->nama ?? ($item->user->nama ?? '') }}</td>
            <td>{{ $item->nama_kegiatan ?? '' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
            <td>{{ $item->lokasi ?? '' }}</td>
            <td>
              @if($item->foto)
              <a href="{{ Storage::url($item->foto) }}" target="_blank">
                <img src="{{ Storage::url($item->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150">
              </a>
               @else
              <span>No Image</span>
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
        @elseif(auth()->user()->hasRole('Staff Kesiswaan'))
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
            <th>Pembina</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Foto</th>
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
            <td>{{ $item->pembina->nama ?? ($item->user->nama ?? '') }}</td>
            <td>{{ $item->nama_kegiatan ?? '' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
            <td>{{ $item->lokasi ?? '' }}</td>
            <td>
              @if($item->foto)
              <a href="{{ Storage::url($item->foto) }}" target="_blank">
                <img src="{{ Storage::url($item->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150">
              </a>
               @else
              <span>No Image</span>
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
            <th>Pembina</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Lokasi</th>
            <th>Foto</th>
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
            <td>{{ $item->pembina->nama ?? ($item->user->nama ?? '') }}</td>
            <td>{{ $item->nama_kegiatan ?? '' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
            <td>{{ $item->lokasi ?? '' }}</td>
            <td>
              @if($item->foto)
              <a href="{{ Storage::url($item->foto) }}" target="_blank">
                <img src="{{ Storage::url($item->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150">
              </a>
               @else
              <span>No Image</span>
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



