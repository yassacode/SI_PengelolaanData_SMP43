<?php

namespace App\Exports;

use App\Models\Ekstrakurikuler;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EkskulExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Ekstrakurikuler::with('user')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kegiatan Ekstrakurikuler',
            'Tanggal',
            'Lokasi',
            'Pembina (Guru)'
        ];
    }

    private $row = 0;

    public function map($ekskul): array
    {
        $this->row++;
        return [
            $this->row,
            $ekskul->nama_kegiatan,
            $ekskul->tanggal,
            $ekskul->lokasi,
            $ekskul->user->nama ?? '-',
        ];
    }
}
