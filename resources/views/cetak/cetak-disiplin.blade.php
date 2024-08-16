@extends('base.layout-cetak')

@section('cetak')
<div class="container p-5">
    <h2>Daftar Pelanggaran Siswa SMP 43 Padang</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
           
          <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Masalah</th>
                <th>Tanggal</th>
                <th>Foto</th>
                <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($disiplin  as $dicipline )
           <tr>
            <td scope="row">{{ $loop->iteration }}</td>
            <td>{{$dicipline->student->nama??''}}</td>
            <td>{{$dicipline->kelas??''}}</td>
            <td>{{$dicipline->masalah??''}}</td>
            <td>{{ \Carbon\Carbon::parse($dicipline->tanggal)->format('d-m-Y')??'' }}</td>
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
           </tr>
           @endforeach
          </tbody>
        </table>
        <div class="text-end">
          <p style="font-size:14px">Padang,<span class="ms-5 me-5">&nbsp; </span>2023</p>
          <p style="margin-top: -10px;font-size:14px;margin-right:35px">Wakil kepala Kesiswaan</p>
          <br>
          <br>
          <span>..............................................</span>
        </div>
      </div>
</div>
@endsection