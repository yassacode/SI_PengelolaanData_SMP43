<?php

namespace Database\Seeders;

use App\Models\PengesahanLaporan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Waka Kesiswaan yang mengajukan laporan
        $wakaUser = User::where('username', 'waka')->first();
        // Kepala Sekolah yang mengesahkan
        $kepsekUser = User::where('username', 'kepsek')->first();
        if (!$wakaUser || !$kepsekUser) return;

        // Buat 3 contoh laporan (2 approved, 1 pending)
        $statuses = ['Approved', 'Approved', 'Pending'];
        $bulan = ['Januari', 'Februari', 'Maret'];

        foreach ($statuses as $index => $status) {
            PengesahanLaporan::create([
                'jenis_laporan' => 'Rekapitulasi Kesiswaan',
                'periode' => 'Bulan ' . $bulan[$index] . ' 2026',
                'tgl_disahkan' => ($status == 'Approved') ? Carbon::now()->format('Y-m-d') : null,
                'status_kepsek' => $status,
            ]);
        }
    }
}
