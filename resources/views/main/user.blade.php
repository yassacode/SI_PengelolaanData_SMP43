@extends('base.layout')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container-xxl flex-grow-1 container-p-y">
 <div class="card">
    <h4 class="card-header">Tabel Data User</h4>
    <a class="nav-link" href="{{ route('user.create')}}"><button type="button" class="btn btn-primary"><i class='bx bxs-user-plus' ></i></button></a>
    <div class="table-responsive">
      <table class="table card-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Level</th>
            <th>Username</th>
            <th>Password</th>
            <th>NIP</th>
            <th>Jabatan</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($user as $users) 
          <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{$users->name ?? ''}}</td>
            <td>{{$users->level ?? ''}}</td>
            <td>{{$users->email ?? ''}}</td>
            <td>{{$users->password ?? ''}}</td>
            <td>{{$users->nip ?? ''}}</td>
            <td>{{$users->jabatan ?? ''}}</td>
            <td>{{$users->alamat ?? ''}}</td>
            <td>{{$users->no_hp ?? ''}}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('user.edit', $users->id) }} "><i class="bx bx-edit-alt me-1"></i>Edit</a>
                  <form action="{{ route('user.destroy', $users->id) }}" method="POST">
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