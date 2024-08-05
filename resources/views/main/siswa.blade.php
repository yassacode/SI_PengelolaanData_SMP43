@extends('base.layout')
@section('title','siswa')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
 <div class="card">
    <h4 class="card-header">Tabel Data Siswa</h4>
    <div class="ms-2 mb-2">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exLargeModal">
      <i class='bx bxs-user-plus' ></i>
    </button>
    
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
          <tr>
            <td>2</td>
            <td>Aldrian Pasha</td>
            <td>422090293210</td>
            <td>2012</td>
            <td>Siti, S.Pd</td>
            <td><span class="badge bg-label-primary me-1">Active</span></td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                  <a class="dropdown-item" href="{{url('/view')}}"><i class="bx bx-show me-1"></i>view</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>Delete</a>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td>1</td>
            <td>Aldrian Pasha</td>
            <td>422090293210</td>
            <td>2012</td>
            <td>08442424328</td>
            <td><span class="badge bg-label-primary me-1">Active</span></td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-show me-1"></i>view</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>Delete</a>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
 </div>
</div>
  @endsection