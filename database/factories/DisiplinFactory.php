<?php

namespace Database\Factories;

use App\Models\Disiplin;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DisiplinFactory extends Factory
{
    protected $model = Disiplin::class;

    public function definition(): array
    {
        return [
            'siswa_id' => Siswa::factory(),
            'user_id' => User::factory(),
            'tanggal' => now()->format('Y-m-d'),
            'masalah' => $this->faker->sentence,
            'keterangan' => 'Diberikan teguran lisan',
            'status_validasi' => Disiplin::STATUS_PENDING,
        ];
    }
}
