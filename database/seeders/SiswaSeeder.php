<?php

namespace Database\Seeders;

use App\Models\Wali;
use App\Models\Siswa;
use App\Models\Akademik;
use App\Models\Kesehatan;
use App\Models\Prestasi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Pastikan ada Staff Kesiswaan yang menjadi user pencatat
        $staffUser = User::where('username', 'staff')->first();
        if (!$staffUser) return;

        for ($i = 0; $i < 5; $i++) {
            // 1. Buat Data Wali
            $wali = Wali::create([
                'nama_ayah' => $faker->name('male'),
                'nama_ibu' => $faker->name('female'),
                'pekerjaan_ayah' => 'Wiraswasta',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'no_hp_ayah' => $faker->phoneNumber,
                'no_hp_ibu' => $faker->phoneNumber,
            ]);

            // 2. Buat Data Siswa
            $siswa = Siswa::create([
                'user_id' => $staffUser->id,
                'wali_id' => $wali->id,
                'nisn' => $faker->numerify('00######'),
                'nama' => $faker->name,
                'ttl' => $faker->city . ', ' . $faker->date('Y-m-d'),
                'agama' => 'Islam',
                'hobi' => $faker->word,
                'thn_msk' => '2023',
            ]);

            // 3. Buat Data Akademik
            Akademik::create([
                'siswa_id' => $siswa->id,
                'asal_paud' => 'PAUD ' . $faker->city,
                'asal_tk' => 'TK ' . $faker->city,
                'asal_sd' => 'SDN ' . $faker->numberBetween(1, 10) . ' ' . $faker->city,
                'beasiswa' => $faker->randomElement(['BOS', 'KIP', null]),
            ]);

            // 4. Buat Data Kesehatan
            Kesehatan::create([
                'siswa_id' => $siswa->id,
                'tb' => $faker->numberBetween(140, 170),
                'bb' => $faker->numberBetween(40, 70),
                'riwayat_sakit' => $faker->randomElement(['Asma', 'Maag', 'Tidak Ada']),
            ]);

            // 5. Buat Data Prestasi (Opsional)
            if ($faker->boolean(70)) {
                Prestasi::create([
                    'siswa_id' => $siswa->id,
                    'kegiatan' => 'Lomba Pencak Silat Tingkat Kota',
                    'juara' => $faker->randomElement(['1', '2', '3']),
                ]);
            }
        }
    }
}
