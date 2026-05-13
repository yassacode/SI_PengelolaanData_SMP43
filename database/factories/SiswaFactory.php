<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Wali;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'wali_id' => Wali::factory(),
            'nisn' => $this->faker->unique()->numerify('##########'),
            'nama' => $this->faker->name,
            'ttl' => $this->faker->city . ', ' . $this->faker->date(),
            'agama' => 'Islam',
            'hobi' => 'Membaca',
            'thn_msk' => $this->faker->year(),
            'alamat' => $this->faker->address,
        ];
    }
}
