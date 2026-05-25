<?php

namespace Database\Factories;

use App\Models\Ekstrakurikuler;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EkstrakurikulerFactory extends Factory
{
    protected $model = Ekstrakurikuler::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nama_kegiatan' => $this->faker->words(3, true),
            'tanggal' => now()->format('Y-m-d'),
            'lokasi' => $this->faker->address,
            'keterangan' => $this->faker->sentence,
            'status_validasi' => Ekstrakurikuler::STATUS_PENDING,
        ];
    }
}
