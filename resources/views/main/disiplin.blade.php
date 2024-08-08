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
    <a class="nav-link" href="{{route('disiplin.create')}}"><button type="button" class="btn btn-primary"><i class='bx bxs-user-plus' ></i></button></a>
    <div class="table-responsive">
      <table class="table card-table">
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
            <td><span class="badge bg-label-primary me-1">Active</span></td>
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
        </tbody>
      </table>
    </div>
  </div>
</div>
  @endsection