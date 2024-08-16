@extends('base.layout-cetak')

@section('cetak')
<div class=" container-xxl flex-grow-1 container-p-y">
 <div class="card">
    <div class="header mt-3">
        <h4> SMP Negeri 43 Padang</h4>
            <br>
        <h5 class="text-center ">BIODATA DIRI SISWA </h5>
        <a class="nav-link" href="{{ route('siswa.show2',$students->id)}}"><button type="button" class="btn btn-primary">cetak</button></a>
         
    </div>
        <div>
            <table class="table-borderless">
             <tbody>
                <tr>
                    <td>User</td>
                    <td>:</td>
                    <td>{{$students->user->name}}</td>
                </tr>
                <tr>
                    <td>Nama Lengkap</td>
                    <td>:</td>
                    <td>{{$students->nama ?? ''}}</td>
                </tr>
                <tr>
                    <td>Tempat/tanggal lahir</td>
                    <td>:</td>
                    <td>{{$students->ttl ?? ''}}</td>
                </tr>
                <tr>
                    <td>Asal SD</td>
                    <td>:</td>
                    <td>{{$students->school->asal_sd ?? ''}}</td>
                </tr>
                <tr>
                    <td>Asal TK</td>
                    <td>:</td>
                    <td>{{$students->school->asal_tk ?? ''}}</td>
                </tr>
                <tr>
                    <td>Asal PAUD</td>
                    <td>:</td>
                    <td>{{$students->school->asal_paud ?? ''}}</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>:</td>
                    <td>{{$students->agama?? ''}}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{$students->alamat?? ''}}</td>
                </tr>
                <tr>
                    <td>Hobi dan Cita-cita</td>
                    <td>:</td>
                    <td>{{$students->hobi?? ''}}</td>
                </tr>
                <tr>
                    <td>Penyakit yang pernah diderita</td>
                    <td>:</td>
                    <td>{{$students->history->sakit ?? ''}}</td>
                </tr>
                <tr>
                    <td>Beasiswa yang pernah diterima</td>
                    <td>:</td>
                    <td>{{$students->history->beasiswa?? ''}}</td>
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
                    <td>{{$students->studentparent->nama_ayah ?? ''}}</td>                
                </tr>
                <tr>
                    <td>
                        <ul class=" mb-0">Pekerjaan Ayah</ul>
                    </td>
                    <td>:</td>
                    <td>{{$students->studentparent->pekerjaan_ayah ?? ''}}</td>         
                </tr>
                <tr>
                    <td>
                        <ul class=" mb-0">Alamat </ul>
                    </td>
                    <td>:</td>
                    <td>{{$students->studentparent->alamat_ayah ?? ''}}</td>         
                </tr>
                <tr>
                    <td>
                        <ul class=" mb-0">Nama Ibu</ul>
                    <td>:</td>
                    <td>{{$students->studentparent->nama_ibu ?? ''}}</td>
                </tr>
                <tr>
                    <td>
                        <ul class=" mb-0">Pekerjaan Ibu</ul>
                    <td>:</td>
                    <td>{{$students->studentparent->pekerjaan_ibu ?? ''}}</td>
                </tr>
                <tr>
                    <td>
                        <ul class=" mb-0">Alamat</ul>
                    <td>:</td>
                    <td>{{$students->studentparent->alamat_ibu ?? ''}}</td>
                </tr>
                <tr>
                    <td>Anak ke-</td>
                    <td>:</td>
                    <td>{{$students->sibling->anak_ke?? ''}}</td>
                </tr>
                <tr>
                    <td>Jumlah saudara kandung</td>
                    <td>:</td>
                    <td>{{$students->sibling->jumlah?? ''}}</td>
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
                    <td>{{$students->school->jrk_sklh ?? ''}}</td>
                </tr>
                <tr>
                    <td>No. HP Siswa</td>
                    <td>:</td>
                    <td>{{$students->no_hp?? ''}}</td>
                </tr>
                <tr>
                    <td>No. HP Ayah</td>
                    <td>:</td>
                    <td>{{$students->studentparent->no_hp_ayah ?? ""}}</td>
                </tr>
                <tr>
                    <td>No. HP Ibu</td>
                    <td>:</td>
                    <td>{{$students->studentparent->no_hp_ibu ?? ''}}</td>
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
                        <td>{{$students->achievement->kegiatan ?? ""}}</td>
                        <td>{{$students->achievement->juara ?? ""}}</td>
                      </tr>
                    </tbody>
                </table>
             </tbody>
            </table>
        </div>
 </div>
</div>
@endsection