@extends('base.layout-cetak')

@section('cetak')
<div class=" container-xxl flex-grow-1 container-p-y">
 <div class="card">
     <div class="header mt-3">
        <h4> SMP Negeri 43 Padang</h4>
            <br>
        <h5 class="text-center ">BIODATA DIRI SISWA </h5>
       
     </div>
        <div>
            <table class="table-borderless">
             <tbody>
                <tr>
                    <td>User</td>
                    <td>:</td>
                    <td>{{$student->user->name}}</td>
                </tr>
                <tr>
                    <td>Nama Lengkap</td>
                    <td>:</td>
                    <td>{{$student->nama ?? ''}}</td>
                </tr>
                <tr>
                    <td>Tempat/tanggal lahir</td>
                    <td>:</td>
                    <td>{{$student->ttl ?? ''}}</td>
                </tr>
                <tr>
                    <td>Asal SD</td>
                    <td>:</td>
                    <td>{{$student->school->asal_sd ?? ''}}</td>
                </tr>
                <tr>
                    <td>Asal TK</td>
                    <td>:</td>
                    <td>{{$student->school->asal_tk ?? ''}}</td>
                </tr>
                <tr>
                    <td>Asal PAUD</td>
                    <td>:</td>
                    <td>{{$student->school->asal_paud ?? ''}}</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>:</td>
                    <td>{{$student->agama?? ''}}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{$student->alamat?? ''}}</td>
                </tr>
                <tr>
                    <td>Hobi dan Cita-cita</td>
                    <td>:</td>
                    <td>{{$student->hobi?? ''}}</td>
                </tr>
                <tr>
                    <td>Penyakit yang pernah diderita</td>
                    <td>:</td>
                    <td>{{$student->history->sakit ?? ''}}</td>
                </tr>
                <tr>
                    <td>Beasiswa yang pernah diterima</td>
                    <td>:</td>
                    <td>{{$student->history->beasiswa?? ''}}</td>
                </tr>
                <tr>
                    <td>Orang Tua</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <ul class=" mb-0">Nama Ayah</ul>
                    </td>
                    <td>:</td>
                    <td>{{$student->studentparent->nama_ayah ?? ''}}</td>                
                </tr>
                <tr>
                    <td>
                        <ul class=" mb-0">Pekerjaan Ayah</ul>
                    </td>
                    <td>:</td>
                    <td>{{$student->studentparent->pekerjaan_ayah ?? ''}}</td>         
                </tr>
                <tr>
                    <td>
                        <ul class=" mb-0">Alamat </ul>
                    </td>
                    <td>:</td>
                    <td>{{$student->studentparent->alamat_ayah ?? ''}}</td>         
                </tr>
                <tr>
                    <td>
                        <ul class=" mb-0">Nama Ibu</ul>
                    <td>:</td>
                    <td>{{$student->studentparent->nama_ibu ?? ''}}</td>
                </tr>
                <tr>
                    <td>
                        <ul class=" mb-0">Pekerjaan Ibu</ul>
                    <td>:</td>
                    <td>{{$student->studentparent->pekerjaan_ibu ?? ''}}</td>
                </tr>
                <tr>
                    <td>
                        <ul class=" mb-0">Alamat</ul>
                    <td>:</td>
                    <td>{{$student->studentparent->alamat_ibu ?? ''}}</td>
                </tr>
                <tr>
                    <td>Anak ke-</td>
                    <td>:</td>
                    <td>{{$student->sibling->anak_ke?? ''}}</td>
                </tr>
                <tr>
                    <td>Jumlah saudara kandung</td>
                    <td>:</td>
                    <td>{{$student->sibling->jumlah?? ''}}</td>
                </tr>
                <tr>
                    <td>Identitas Wali</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Nama Wali</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Pekerjaan wali</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Alamat wali</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Jarak tempuh ke sekolah</td>
                    <td>:</td>
                    <td>{{$student->school->jrk_sklh ?? ''}}</td>
                </tr>
                <tr>
                    <td>No. HP Siswa</td>
                    <td>:</td>
                    <td>{{$student->no_hp?? ''}}</td>
                </tr>
                <tr>
                    <td>No. HP Ayah</td>
                    <td>:</td>
                    <td>{{$student->studentparent->no_hp_ayah ?? ""}}</td>
                </tr>
                <tr>
                    <td>No. HP Ibu</td>
                    <td>:</td>
                    <td>{{$student->studentparent->no_hp_ibu ?? ''}}</td>
                </tr>
                <tr>
                    <td>No. HP Wali</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Prestasi Akademi dan Non Akademik</td>
                    <td></td>
                    <td></td>
                </tr>
                <table class="table border-2 ml-auto text-center mt-2">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">kegiatan</th>
                        <th scope="col">juara</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>{{$student->achievement->kegiatan ?? ""}}</td>
                        <td>{{$student->achievement->juara ?? ""}}</td>
                      </tr>
                    </tbody>
                </table>
             </tbody>
            </table>
        </div>
    
        <div class="page-break"></div>  
        <div class="header mb-4 text-center">
            <h4> PENANGANAN MASALAH SISWA </h4>
     </div>
     <div class="table-responsive">
        @if ($discipline->isEmpty())
        <p>Data disiplin tidak tersedia.</p>
        @else
        <table class="table-borderless">
            <tbody>
               <tr>
                   <td>Nama</td>
                   <td>:</td>
                   <td>{{ $student->nama }}</td>
               </tr>
               <tr>
                   <td>Kelas</td>
                   <td>:</td>
                   <td>{{ $discipline->isEmpty() ? 'Kelas tidak tersedia' : $discipline->first()->kelas }}</td>
               </tr>
            </tbody>
        </table>
        <table class="table table-bordered table-sm ">
         <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Masalah</th>
                <th>Solusi</th>
                <th>Foto</th>
                <th>Keterangan</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($discipline as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal}}</td>
                    <td>{{ $item->masalah }}</td>
                    <td>{{ $item->solusi }}</td>
                    <td>
                        @if($item->foto)
                            <a href="{{ Storage::url($item->foto) }}" target="_blank">
                                <img src="{{ Storage::url($item->foto) }}" alt="Foto" class="img img-fluid" width="150" height="150">
                            </a>
                        @else
                            <span>No Image</span>
                        @endif
                    </td>
                    <td>{{ $item->keterangan }}</td>
                </tr>
            @endforeach
         </tbody>
        </table>
        @endif
      </div>
    </div>
 </div>


{{-- <script>
    window.onload = function() {
        window.print();
    };
    </script> --}}
@endsection