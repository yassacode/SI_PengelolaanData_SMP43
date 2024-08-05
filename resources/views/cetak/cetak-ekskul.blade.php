@extends('base.layout-cetak')

@section('cetak')
<div class="container-xxl flex-grow-1 container-p-y">
       <h4 class="text-center mb-5">Kegiatan Ekstrakurikuler</h4>
        <h6>Hari dan tanggal: </h6>
        <div class="table-responsive">
         <table class="table card-table">
            <thead>
             <tr>
               <th>No</th>
               <th>Nama Ekstrakurikuler</th>
               <th>Nama Kegiatan</th>
               <th>Tanggal</th>
               <th>Lokasi</th>
               <th>Foto</th>
               <th>Keterangan</th>
             </tr>
           </thead>
           <tbody>
             <tr>
               <td>1</td>
               <td>Aldrian Pasha</td>
               <td>422090293210</td>
               <td>422090293210</td>
               <td>2012</td>
               <td>08442424328</td>
               <td>08442424328</td>
             </tr>
           </tbody>
         </table>
       </div>
     </div>
   </div>
@endsection