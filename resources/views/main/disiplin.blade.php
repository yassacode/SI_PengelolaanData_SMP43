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
        <div class="d-flex justify-content-end me-3">
          <form action="{{ route('disiplin.index') }}" method="GET">
              <input class="me-2" type="text" name="search" placeholder="cari nama dan masalah" value="{{ request()->input('search') }}">
              <button type="submit" class="btn btn-primary">Cari</button>
          </form>
        </div>
        @if(auth()->user()->level == 'admin')
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
            <th>Kelas</th>
            <th>Masalah</th>
            <th>Tanggal</th>
            <th>Foto</th>
            <th>Keterangan</th>
            <th>Validasi</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if($disiplin->isEmpty())
            <tr>
                <td colspan="11" class="text-center">Tidak ada data yang ditemukan.</td>
            </tr>
        @else
            @foreach ($disiplin as $dicipline)
            <tr>
                <td scope="row">{{ $loop->iteration }}</td>
                <td>{{ $dicipline->user->name ?? '' }}</td>
                <td>{{ $dicipline->student->nama ?? '' }}</td>
                <td>{{ $dicipline->kelas ?? '' }}</td>
                <td>{{ $dicipline->masalah ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($dicipline->tanggal)->format('d-m-Y') ?? '' }}</td>
                <td>
                    @if($dicipline->foto)
                    <a href="{{ Storage::url($dicipline->foto) }}" target="_blank">
                        <img src="{{ Storage::url($dicipline->foto) }}" alt="" class="img img-fluid" width="150" height="150">
                    </a>
                    @else
                    <span>No Image</span>
                    @endif
                </td>
                <td>{{ $dicipline->keterangan ?? '' }}</td>
                <td>
                    @if ($dicipline->status == 'WAITING')
                    <form action="{{ route('disiplin/update/status.updateStts', $dicipline->id) }}" method="POST" onsubmit="return handleStatusChange(this, '{{ $dicipline->id }}');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-primary" value="ACCEPTED" name="status">TERIMA</button>
                        <button type="submit" class="btn btn-sm btn-danger" value="DENIED" name="status">TOLAK</button>
                    </form>
                    @elseif ($dicipline->status == 'ACCEPTED')
                    <span class="badge bg-label-success me-1">DITERIMA</span>
                    @elseif ($dicipline->status == 'DENIED')
                    <span class="badge bg-label-danger me-1">DITOLAK</span>
                    @else
                    <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                    @endif
                </td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                        <div class="dropdown-menu">
                          @if ($dicipline->status !== 'ACCEPTED')
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
        @elseif(auth()->user()->level == 'kepala sekolah')
        <thead>
          <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Masalah</th>
            <th>Tanggal</th>
            <th>Foto</th>
            <th>Keterangan</th>
            <th>Validasi</th>
          </tr>
        </thead>
        <tbody>
          @if($disiplin->isEmpty())
          <tr>
              <td colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
          </tr>
          @else
          @foreach ( $disiplin as $dicipline )        
          <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{$dicipline->user_id??''}}</td>
            <td>{{$dicipline->student->nama??''}}</td>
            <td>{{$dicipline->kelas??''}}</td>
            <td>{{$dicipline->masalah??''}}</td>
            <td>{{$dicipline->tanggal??''}}</td>
            <td>
              @if($dicipline->foto)
              <a href="{{ Storage::url($dicipline->foto) }}" target="_blank">
                <img src="{{ Storage::url($dicipline->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150"></td>
              </a>
              {{-- <img src="{{ Storage::url($dicipline->foto) }}, 'public' }}" alt="Foto" style="width: 100px; height: auto;"> --}}
               @else
              <span>No Image</span>
              @endif
            </td>
            <td>{{$dicipline->keterangan??''}}</td>
            <td>
              @if ($dicipline->status == 'WAITING')
                <span class="badge bg-label-warning me-1">MENUNGGU</span>
              @elseif ($dicipline->status == 'ACCEPTED')
                <span class="badge bg-label-success me-1">DITERIMA</span>
              @elseif ($dicipline->status == 'DENIED')
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
        <a class="nav-link" href="{{route('disiplin.create')}}"><button type="button" class="btn btn-primary"><i class='bx bxs-user-plus' ></i></button></a>
        <thead>
          <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Masalah</th>
            <th>Tanggal</th>
            <th>Foto</th>
            <th>Keterangan</th>
            <th>Validasi</th>
            <th>Action</th> 
          </tr>
        </thead>
        <tbody>
          @if($disiplin->isEmpty())
          <tr>
              <td colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
          </tr>
          @else
          @foreach ( $disiplin as $dicipline )        
          <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{$dicipline->user_id??''}}</td>
            <td>{{$dicipline->student->nama??''}}</td>
            <td>{{$dicipline->kelas??''}}</td>
            <td>{{$dicipline->masalah??''}}</td>
            <td>{{$dicipline->tanggal??''}}</td>
            <td>
              @if($dicipline->foto)
              <a href="{{ Storage::url($dicipline->foto) }}" target="_blank">
                <img src="{{ Storage::url($dicipline->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150"></td>
              </a>
              {{-- <img src="{{ Storage::url($dicipline->foto) }}, 'public' }}" alt="Foto" style="width: 100px; height: auto;"> --}}
               @else
              <span>No Image</span>
              @endif
            </td>
            <td>{{$dicipline->keterangan??''}}</td>
            <td>
                @if ($dicipline->status == 'WAITING')
                <form action="{{route('disiplin/update/status.updateStts', $dicipline->id)}}" method="POST">
                  @csrf
                  @method('PUT')
                  <button type="submit" class="btn btn-sm btn-primary" value="ACCEPTED" name="status">TERIMA</button>
                  <button type="submit" class="btn btn-sm btn-danger" value="DENIED" name="status">TOLAK</button>
                </form>
                @elseif ($dicipline->status == 'ACCEPTED')
                  <span class="badge bg-label-success me-1">DITERIMA</span>
                @elseif ($dicipline->status == 'DENIED')
                  <span class="badge bg-label-danger me-1">DITOLAK</span>
                @else
                  <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                @endif
            </td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('disiplin.edit', $dicipline->id) }} "><i class="bx bx-edit-alt me-1"></i>Edit</a>
                  <form action="{{ route('disiplin.destroy', $dicipline->id) }}" method="POST">
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
        <a class="nav-link" href="{{route('disiplin.create')}}"><button type="button" class="btn btn-primary"><i class='bx bxs-user-plus' ></i></button></a>
        <thead>
          <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Masalah</th>
            <th>Tanggal</th>
            <th>Foto</th>
            <th>Keterangan</th>
            <th>Validasi</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @if($disiplin->isEmpty())
          <tr>
              <td colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
          </tr>
          @else
          @foreach ( $disiplin as $dicipline )        
          <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{$dicipline->user_id??''}}</td>
            <td>{{$dicipline->student->nama??''}}</td>
            <td>{{$dicipline->kelas??''}}</td>
            <td>{{$dicipline->masalah??''}}</td>
            <td>{{$dicipline->tanggal??''}}</td>
            <td>
              @if($dicipline->foto)
              <a href="{{ Storage::url($dicipline->foto) }}" target="_blank">
                <img src="{{ Storage::url($dicipline->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150"></td>
              </a>
              {{-- <img src="{{ Storage::url($dicipline->foto) }}, 'public' }}" alt="Foto" style="width: 100px; height: auto;"> --}}
               @else
              <span>No Image</span>
              @endif
            </td>
            <td>{{$dicipline->keterangan??''}}</td>
            <td>
                @if ($dicipline->status == 'WAITING')
                  <span class="badge bg-label-warning me-1">MENUNGGU</span>
                @elseif ($dicipline->status == 'ACCEPTED')
                  <span class="badge bg-label-success me-1">DITERIMA</span>
                @elseif ($dicipline->status == 'DENIED')
                  <span class="badge bg-label-danger me-1">DITOLAK</span>
                @else
                  <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                @endif
            </td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('disiplin.edit', $dicipline->id) }} "><i class="bx bx-edit-alt me-1"></i>Edit</a>
                  <form action="{{ route('disiplin.destroy', $dicipline->id) }}" method="POST">
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
        <a class="nav-link" href="{{route('disiplin.create')}}"><button type="button" class="btn btn-primary"><i class='bx bxs-user-plus' ></i></button></a>
        <thead>
          <tr>
            <th>No</th>
            <th>User</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Masalah</th>
            <th>Tanggal</th>
            <th>Foto</th>
            <th>Keterangan</th>
            <th>Validasi</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @if($disiplin->isEmpty())
          <tr>
              <td colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
          </tr>
          @else
          @foreach ( $disiplin as $dicipline )        
          <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{$dicipline->user_id??''}}</td>
            <td>{{$dicipline->student->nama??''}}</td>
            <td>{{$dicipline->kelas??''}}</td>
            <td>{{$dicipline->masalah??''}}</td>
            <td>{{$dicipline->tanggal??''}}</td>
            <td>
              @if($dicipline->foto)
              <a href="{{ Storage::url($dicipline->foto) }}" target="_blank">
                <img src="{{ Storage::url($dicipline->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150"></td>
              </a>
              {{-- <img src="{{ Storage::url($dicipline->foto) }}, 'public' }}" alt="Foto" style="width: 100px; height: auto;"> --}}
               @else
              <span>No Image</span>
              @endif
            </td>
            <td>{{$dicipline->keterangan??''}}</td>
            @if ($dicipline->status == 'WAITING')
              <span class="badge bg-label-warning me-1">MENUNGGU</span>
            @elseif ($dicipline->status == 'ACCEPTED')
              <span class="badge bg-label-success me-1">DITERIMA</span>
            @elseif ($dicipline->status == 'DENIED')
              <span class="badge bg-label-danger me-1">DITOLAK</span>
            @else
              <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
            @endif
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('disiplin.edit', $dicipline->id) }} "><i class="bx bx-edit-alt me-1"></i>Edit</a>
                  <form action="{{ route('disiplin.destroy', $dicipline->id) }}" method="POST">
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