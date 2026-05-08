<?php

namespace App\Exports;

use App\Models\Disiplin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DisiplinExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Disiplin::with(['siswa', 'pelapor', 'validator'])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Pelanggaran (Masalah)',
            'Tanggal',
            'Dilaporkan Oleh',
            'Status Validasi'
        ];
    }

    private $row = 0;

    public function map($disiplin): array
    {
        $this->row++;
        return [
            $this->row,
            $disiplin->siswa->nama ?? '-',
            $disiplin->masalah,
            $disiplin->tanggal,
            $disiplin->pelapor->nama ?? '-',
            $disiplin->status_validasi,
        ];
    }
}
