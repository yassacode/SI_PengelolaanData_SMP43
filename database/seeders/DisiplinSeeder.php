<?php

namespace Database\Seeders;

use App\Models\Disiplin;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DisiplinSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Pastikan ada Guru BK yang menjadi pelapor
        $guruBkUser = User::where('username', 'gurubk')->first();
        // Waka Kesiswaan yang memvalidasi
        $wakaUser = User::where('username', 'waka')->first();
        if (!$guruBkUser || !$wakaUser) return;

        // Ambil beberapa siswa secara acak
        $siswas = Siswa::inRandomOrder()->take(5)->get();

        foreach ($siswas as $siswa) {
            $status = $faker->randomElement(['Pending', 'Approved', 'Rejected']);
            
            Disiplin::create([
                'user_id' => $guruBkUser->id,
                'siswa_id' => $siswa->id,
                'validator_id' => ($status != 'Pending') ? $wakaUser->id : null,
                'masalah' => $faker->randomElement(['Terlambat datang sekolah', 'Tidak mengerjakan PR', 'Seragam tidak lengkap', 'Berkelahi']),
                'tanggal' => Carbon::now()->subDays(rand(1, 30))->format('Y-m-d'),
                'status_validasi' => $status
            ]);
        }
    }
}
