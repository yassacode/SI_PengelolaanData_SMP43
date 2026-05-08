@extends('base.layout-cetak')
@section('title','cetak disiplin')
@section('cetak')
<div class="container p-5">
    <h2 class="text-center">Daftar Pelanggaran Siswa SMP 43 Padang</h2>

    @if($disiplin->isNotEmpty() && $month)
    <h5>Bulan : {{ \Carbon\Carbon::parse($month)->locale('id')->translatedFormat('F Y') ?? '' }}</h5>
    
    @endif
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
            <td>{{$dicipline->siswa->nama??''}}</td>
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
          <p style="font-size:14px">Padang,<span class="ms-5 me-4">&nbsp; </span>{{ \Carbon\Carbon::now()->year }}</p>
          <p style="margin-top: -10px;font-size:14px;margin-right:8px">Wakil kepala Kesiswaan</p>
          <br>
          <br>
          <span>.........................................</span>
        </div>
      </div>
</div>
<script>
  window.onload = function() {
      window.print();
  };
  </script>
@endsection



