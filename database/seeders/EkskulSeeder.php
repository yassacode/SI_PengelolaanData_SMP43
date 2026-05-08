<?php

namespace Database\Seeders;

use App\Models\Ekstrakurikuler;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class EkskulSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Pastikan ada Guru yang menjadi pembina ekskul
        $guruUser = User::where('username', 'guru')->first();
        if (!$guruUser) return;

        $ekskuls = ['Pramuka', 'PMR', 'Pencak Silat', 'Tari Tradisional', 'Rohis'];

        foreach ($ekskuls as $nama_ekskul) {
            $ekskul = Ekstrakurikuler::create([
                'user_id' => $guruUser->id,
                'nama_kegiatan' => $nama_ekskul,
                'tanggal' => Carbon::now()->subDays(rand(1, 30))->format('Y-m-d'),
                'lokasi' => 'Lapangan Sekolah',
            ]);

            // Tambahkan beberapa siswa ke dalam ekskul ini secara acak
            $siswas = Siswa::inRandomOrder()->take(3)->pluck('id');
            foreach ($siswas as $siswa_id) {
                DB::table('anggota_ekskuls')->insert([
                    'siswa_id' => $siswa_id,
                    'ekstrakurikuler_id' => $ekskul->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
