@extends('base.layout')

@section('title','disiplin')
@section('content')
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
            <td>{{$dicipline->student_id->nama??''}}</td>
            <td>{{$dicipline->kelas??''}}</td>
            <td>{{$dicipline->masalah??''}}</td>
            <td>{{$dicipline->tanggal??''}}</td>
            <td>{{$dicipline->foto??''}}</td>
            <td>{{$dicipline->keterangan??''}}</td>
            <td><span class="badge bg-label-primary me-1">Active</span></td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>Delete</a>
                </div>
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