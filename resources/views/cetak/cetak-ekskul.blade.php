@extends('base.layout-cetak')
@section('title','cetak ekskul')
@section('cetak')
<div class="container p-5">
    <h4 class="text-center mb-5">Kegiatan Ekstrakurikuler</h4>
    
    @if($item->isNotEmpty() && $month)
    <h5>Bulan : {{ \Carbon\Carbon::parse($month)->locale('id')->translatedFormat('F Y') ?? '' }}</h5>
    
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="padding: 5px; width: 5%;">No</th>
                <th style="padding: 10px; width: 15%;">Nama Ekstrakurikuler</th>
                <th>Nama Kegiatan</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Foto</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($item as $item)
            <tr>
                <td scope="row">{{ $loop->iteration }}</td>
                <td>{{ $item->ekskul ?? '' }}</td>
                <td>{{ $item->kegiatan ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l, d F Y') ?? '' }}</td>
                <td>{{ $item->lokasi ?? '' }}</td>
                <td>
                    @if($item->foto)
                    <a href="{{ Storage::url($item->foto) }}" target="_blank">
                        <img src="{{ Storage::url($item->foto ?? '') }}" alt="" class="img img-fluid" width="150" height="150">
                    </a>
                    @else
                    <span>No Image</span>
                    @endif
                </td>
                <td>{{ $item->keterangan ?? '' }}</td>
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

<style>
    /* Mengatur tabel agar tidak responsif dan mengatur tampilan untuk cetak */
    table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
        margin: 0;
        font-size: 12px; /* Sesuaikan ukuran font untuk cetak */
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    th {
        text-align: left;
    }

    img {
        max-width: 100px;
        height: auto;
    }

    @media print {
        .container {
            width: 100%;
            padding: 0;
        }

        table {
            font-size: 10px; /* Sesuaikan ukuran font untuk cetak */
        }

        img {
            max-width: 80px;
            height: auto;
        }
    }
</style>
@endsection




