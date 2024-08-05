@extends('base.layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
 <div class="card">
    <h4 class="card-header">Tabel Data Kegiatan Ekstrakurikuler</h4>
    <a class="nav-link" href="{{ route('ekskul.create')}}"><button type="button" class="btn btn-primary"><i class='bx bxs-user-plus' ></i></button></a>
    <div class="table-responsive">
      <table class="table card-table">
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
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)  
          <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{ $item->user_id ?? '' }}</td>
            <td>{{ $item->ekskul ?? '' }}</td>
            <td>{{ $item->kegiatan ?? '' }}</td>
            <td>{{ $item->tanggal ?? '' }}</td>
            <td>{{ $item->lokasi ?? '' }}</td>
            <td>{{ $item->foto ?? '' }}</td>
            <td>{{ $item->keterangan ?? '' }}</td>
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
        </tbody>
      </table>
    </div>
  </div>
</div>
  @endsection