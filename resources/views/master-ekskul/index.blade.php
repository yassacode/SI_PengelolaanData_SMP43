@extends('base.layout')
@section('title', 'Master Ekskul')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h4 class="card-header">Daftar Nama Ekstrakurikuler</h4>
            <div class="table-responsive">
                <div class="d-flex justify-content-between align-items-center mb-3 px-3">
                    <a href="{{ route('master-ekskul.create') }}">
                        <button type="button" class="btn btn-primary"><i class='bx bxs-plus-circle'></i> Tambah Ekskul</button>
                    </a>
                </div>
                <table class="table card-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Ekskul</th>
                            <th>Keterangan</th>
                            <th>Jumlah Anggota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ekskuls as $ekskul)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('master-ekskul.show', $ekskul->id) }}" style="font-weight: bold; text-decoration: underline;">
                                        {{ $ekskul->nama }}
                                    </a>
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($ekskul->keterangan, 50) ?? '-' }}</td>
                                <td>{{ $ekskul->siswas_count }} Siswa</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('master-ekskul.edit', $ekskul->id) }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('master-ekskul.destroy', $ekskul->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
