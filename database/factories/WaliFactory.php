<?php

namespace Database\Factories;

use App\Models\Wali;
use Illuminate\Database\Eloquent\Factories\Factory;

class WaliFactory extends Factory
{
    protected $model = Wali::class;

    public function definition(): array
    {
        return [
            'nama_ayah' => $this->faker->name('male'),
            'nama_ibu' => $this->faker->name('female'),
            'pekerjaan_ayah' => 'Swasta',
            'pekerjaan_ibu' => 'IRT',
            'alamat_ayah' => $this->faker->address,
            'alamat_ibu' => $this->faker->address,
            'no_hp_ayah' => $this->faker->phoneNumber,
            'no_hp_ibu' => $this->faker->phoneNumber,
        ];
    }
}
