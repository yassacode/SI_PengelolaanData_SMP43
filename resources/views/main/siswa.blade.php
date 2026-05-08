@extends('base.layout')
@section('title','siswa')

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
        <div>
          @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Staff Kesiswaan') || auth()->user()->hasRole('Waka Kesiswaan'))
          <a class="btn btn-primary" href="{{ route('siswa.create1')}}"><i class='bx bxs-user-plus' ></i> Tambah</a>
          @endif
        </div>
        <form action="{{ route('siswa.index') }}" method="GET" class="d-flex pe-3">
            <input class="form-control me-2" type="text" name="search" placeholder="Cari Nama Siswa" value="{{ request()->input('search') }}">
            <button type="submit" class="btn btn-primary me-2">Cari</button>
            <a href="{{ route('siswa.export.pdf') }}" class="btn btn-danger me-2" title="Export PDF"><i class='bx bxs-file-pdf'></i></a>
            <a href="{{ route('siswa.export.excel') }}" class="btn btn-success" title="Export Excel"><i class='bx bx-spreadsheet'></i></a>
        </form>
      </div>
      <div class="table-responsive">
      <table class="table card-table">

        @if(auth()->user()->hasRole('Admin'))
        <a class="" href="{{ route('siswa.create1')}}"><button type="button" class="btn btn-primary"><i class='bx bxs-user-plus' ></i></button></a>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NISN</th>
            <th>tahun masuk</th>
            <th>user</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @if($siswa->isEmpty())
              <tr>
                  <td colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
              </tr>
          @else
              <!-- Loop siswa untuk semua level user -->
              @foreach ($siswa as $students)      
              <tr>
                  <td scope="row">{{ $loop->iteration }}</td>
                  <td>{{$students->nama ?? ''}}</td>
                  <td>{{$students->nisn ?? ''}}</td>
                  <td>{{$students->thn_msk ?? ''}}</td>
                  <td>{{$students->user->nama ?? ''}}</td>
                  <td>
                    @if (($students->akademik->status ?? null) == 'WAITING')
                    <form action="{{route('siswa/update/status.updateStts', $students->id)}}" method="POST">
                      @csrf
                      @method('PUT')
                      <button type="submit" class="btn btn-sm btn-primary" value="ACCEPTED" name="status">TERIMA</button>
                      <button type="submit" class="btn btn-sm btn-danger" value="DENIED" name="status">TOLAK</button>
                    </form>
                    @elseif (($students->akademik->status ?? null) == 'ACCEPTED')
                      <span class="badge bg-label-success me-1">DITERIMA</span>
                    @elseif (($students->akademik->status ?? null) == 'DENIED')
                      <span class="badge bg-label-danger me-1">DITOLAK</span>
                    @else
                      <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                    @endif
                  </td>
                  <td>
                      <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                          <div class="dropdown-menu">
                              <a class="dropdown-item" href="{{ route('siswa.show1', $students->id) }} "><i class="bx bxs-show"></i>view</a>
                                @if (($students->akademik->status ?? null) !== 'ACCEPTED')
                                <a class="dropdown-item" href="{{ route('siswa.edit1', $students->id) }}">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                @endif
                              <form action="{{ route('siswa.destroy', $students->id) }}" method="POST">
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
            <th>Nama</th>
            <th>NISN</th>
            <th>tahun masuk</th>
            <th>user</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @if($siswa->isEmpty())
              <tr>
                  <td colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
              </tr>
          @else
              <!-- Loop siswa untuk semua level user -->
              @foreach ($siswa as $students)      
              <tr>
                  <td scope="row">{{ $loop->iteration }}</td>
                  <td>{{$students->nama ?? ''}}</td>
                  <td>{{$students->nisn ?? ''}}</td>
                  <td>{{$students->thn_msk ?? ''}}</td>
                  <td>{{$students->user->nama ?? ''}}</td>
                  <td>
                    @if (($students->akademik->status ?? null) == 'WAITING')
                      <span class="badge bg-label-warning me-1">MENUNGGU</span>
                    @elseif (($students->akademik->status ?? null) == 'ACCEPTED')
                      <span class="badge bg-label-success me-1">DITERIMA</span>
                    @elseif (($students->akademik->status ?? null) == 'DENIED')
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
        <a class="nav-link" href="{{ route('siswa.create1')}}"><button type="button" class="btn btn-primary"><i class='bx bxs-user-plus' ></i></button></a>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NISN</th>
            <th>tahun masuk</th>
            <th>user</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @if($siswa->isEmpty())
              <tr>
                  <td colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
              </tr>
          @else
              <!-- Loop siswa untuk semua level user -->
              @foreach ($siswa as $students)      
              <tr>
                  <td scope="row">{{ $loop->iteration }}</td>
                  <td>{{$students->nama ?? ''}}</td>
                  <td>{{$students->nisn ?? ''}}</td>
                  <td>{{$students->thn_msk ?? ''}}</td>
                  <td>{{$students->user->nama ?? ''}}</td>
                  <td>
                    @if (($students->akademik->status ?? null) == 'WAITING')
                    <form action="{{route('siswa/update/status.updateStts', $students->id)}}" method="POST">
                      @csrf
                      @method('PUT')
                      <button type="submit" class="btn btn-sm btn-primary" value="ACCEPTED" name="status">TERIMA</button>
                      <button type="submit" class="btn btn-sm btn-danger" value="DENIED" name="status">TOLAK</button>
                    </form>
                    @elseif (($students->akademik->status ?? null) == 'ACCEPTED')
                      <span class="badge bg-label-success me-1">DITERIMA</span>
                    @elseif (($students->akademik->status ?? null) == 'DENIED')
                      <span class="badge bg-label-danger me-1">DITOLAK</span>
                    @else
                      <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                    @endif
                  </td>
                  <td>
                      <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                          <div class="dropdown-menu">
                              <a class="dropdown-item" href="{{ route('siswa.show1', $students->id) }} "><i class="bx bxs-show"></i>view</a>
                                @if (($students->akademik->status ?? null) !== 'ACCEPTED')
                                <a class="dropdown-item" href="{{ route('siswa.edit1', $students->id) }}">
                                    <i class="bx bx-edit-alt me-1"></i> Edit
                                </a>
                                @endif
                              <form action="{{ route('siswa.destroy', $students->id) }}" method="POST">
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
        <a class="nav-link" href="{{ route('siswa.create1')}}"><button type="button" class="btn btn-primary"><i class='bx bxs-user-plus' ></i></button></a>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NISN</th>
            <th>tahun masuk</th>
            <th>user</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @if($siswa->isEmpty())
              <tr>
                  <td colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
              </tr>
          @else
              <!-- Loop siswa untuk semua level user -->
              @foreach ($siswa as $students)      
              <tr>
                  <td scope="row">{{ $loop->iteration }}</td>
                  <td>{{$students->nama ?? ''}}</td>
                  <td>{{$students->nisn ?? ''}}</td>
                  <td>{{$students->thn_msk ?? ''}}</td>
                  <td>{{$students->user->nama ?? ''}}</td>
                  <td>
                    @if (($students->akademik->status ?? null) == 'WAITING')
                      <span class="badge bg-label-warning me-1">MENUNGGU</span>
                    @elseif (($students->akademik->status ?? null) == 'ACCEPTED')
                      <span class="badge bg-label-success me-1">DITERIMA</span>
                    @elseif (($students->akademik->status ?? null) == 'DENIED')
                      <span class="badge bg-label-danger me-1">DITOLAK</span>
                    @else
                      <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                    @endif
                  </td>
                  <td>
                      <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                          <div class="dropdown-menu">
                              <a class="dropdown-item" href="{{ route('siswa.show1', $students->id) }} "><i class="bx bxs-show"></i>view</a>
                              @if (($students->akademik->status ?? null) !== 'ACCEPTED')
                              <a class="dropdown-item" href="{{ route('siswa.edit1', $students->id) }}">
                                  <i class="bx bx-edit-alt me-1"></i> Edit
                              </a>
                              @endif
                              <form action="{{ route('siswa.destroy', $students->id) }}" method="POST">
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
        <a class="nav-link" href="{{ route('siswa.create1')}}"><button type="button" class="btn btn-primary"><i class='bx bxs-user-plus' ></i></button></a>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NISN</th>
            <th>tahun masuk</th>
            <th>user</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @if($siswa->isEmpty())
              <tr>
                  <td colspan="7" class="text-center">Tidak ada data yang ditemukan.</td>
              </tr>
          @else
              <!-- Loop siswa untuk semua level user -->
              @foreach ($siswa as $students)      
              <tr>
                  <td scope="row">{{ $loop->iteration }}</td>
                  <td>{{$students->nama ?? ''}}</td>
                  <td>{{$students->nisn ?? ''}}</td>
                  <td>{{$students->thn_msk ?? ''}}</td>
                  <td>{{$students->user->nama ?? ''}}</td>
                  <td>
                    @if (($students->akademik->status ?? null) == 'WAITING')
                      <span class="badge bg-label-warning me-1">MENUNGGU</span>
                    @elseif (($students->akademik->status ?? null) == 'ACCEPTED')
                      <span class="badge bg-label-success me-1">DITERIMA</span>
                    @elseif (($students->akademik->status ?? null) == 'DENIED')
                      <span class="badge bg-label-danger me-1">DITOLAK</span>
                    @else
                      <span class="badge bg-label-danger me-1">TIDAK DIKETAHUI</span>
                    @endif
                  </td>
                  <td>
                      <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                          <div class="dropdown-menu">
                              <a class="dropdown-item" href="{{ route('siswa.show1', $students->id) }} "><i class="bx bxs-show"></i>view</a>
                              <a class="dropdown-item" href="{{ route('siswa.edit1', $students->id) }} "><i class="bx bx-edit-alt me-1"></i>Edit</a>
                              <form action="{{ route('siswa.destroy', $students->id) }}" method="POST">
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
</div>
  @endsection



