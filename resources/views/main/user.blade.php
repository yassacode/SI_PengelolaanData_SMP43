@extends('base.layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
 <div class="card">
    <h4 class="card-header">Tabel Data Siswa</h4>
    <a class="nav-link" href="#"><button type="button" class="btn btn-primary"><i class='bx bxs-user-plus' ></i></button></a>
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
          <tr>
            <td>1</td>
            <td>Aldrian Pasha</td>
            <td>422090293210</td>
            <td>2012</td>
            <td>08442424328</td>
            <td>08442424328</td>
            <td>08442424328</td>
            <td>08442424328</td>
            <td>08442424328</td>
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
        </tbody>
      </table>
    </div>
  </div>
</div>
  @endsection