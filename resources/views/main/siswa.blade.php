@extends('base.layout')
@section('title','siswa')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
 <div class="card">
    <h4 class="card-header">Tabel Data Siswa</h4>
    <div class="ms-2 mb-2">
      <a class="nav-link" href="{{ route('siswa.create1')}}"><button type="button" class="btn btn-primary"><i class='bx bxs-user-plus' ></i></button></a>
           <div class="table-responsive">
      <table class="table card-table">
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
          @foreach ($siswa as $students)      
          <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{$students->nama ?? ''}}</td>
            <td>{{$students->nisn ?? ''}}</td>
            <td>{{$students->thn_msk ?? ''}}</td>
            <td>{{$students->user_id ?? ''}}</td>
            <td><span class="badge bg-label-primary me-1">Active</span></td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  {{-- <a class="dropdown-item" href="{{ route('siswa.create1', $students->id) }} "><i class="bx bx-edit-alt me-1"></i>create</a> --}}
                  <a class="dropdown-item" href="{{ route('siswa.show1', $students->id) }} "><i class="bx bxs-show"></i>view</a>
                  <a class="dropdown-item" href="{{ route('siswa.edit', $students->id) }} "><i class="bx bx-edit-alt me-1"></i>Edit</a>
                  <form action="{{ route('siswa.destroy', $students->id) }}" method="POST">
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
</div>
  @endsection