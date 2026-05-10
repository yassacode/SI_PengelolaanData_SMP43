<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SiswaExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tahun;
    private $row = 0;

    public function __construct($tahun = null)
    {
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return Siswa::with(['wali', 'akademik'])
            ->when($this->tahun, function ($query) {
                return $query->where('thn_msk', $this->tahun);
            })
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'NISN',
            'Tahun Masuk',
            'Status Akademik',
            'Asal Sekolah',
            'Nama Ayah',
            'No HP Ayah'
        ];
    }

    public function map($siswa): array
    {
        $this->row++;
        return [
            $this->row,
            $siswa->nama,
            $siswa->nisn,
            $siswa->thn_msk,
            $siswa->akademik->status ?? '-',
            $siswa->akademik->asal_sd ?? '-',
            $siswa->wali->nama_ayah ?? '-',
            $siswa->wali->no_hp_ayah ?? '-',
        ];
    }
}
