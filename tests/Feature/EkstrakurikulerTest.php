<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Ekstrakurikuler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EkstrakurikulerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        \Spatie\Permission\Models\Role::create(['name' => 'Guru']);
        $this->user = User::factory()->create();
        $this->user->assignRole('Guru');
    }

    /** @test */
    public function test_guru_can_add_extracurricular_activity()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('ekskul.store'), [
            'nama_kegiatan' => 'Latihan Pramuka',
            'tanggal' => now()->format('Y-m-d'),
            'lokasi' => 'Lapangan Sekolah',
            'keterangan' => 'Latihan rutin mingguan',
        ]);

        $response->assertRedirect(route('ekskul.index'));
        $response->assertSessionHas('success', 'Data Berhasil Ditambahkan');

        $this->assertDatabaseHas('ekstrakurikulers', [
            'nama_kegiatan' => 'Latihan Pramuka',
            'lokasi' => 'Lapangan Sekolah',
        ]);
    }

    /** @test */
    public function test_guru_can_view_print_ekskul_data()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('ekskul.show'), [
            'month' => now()->format('Y-m'),
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('cetak.cetak-ekskul');
        $response->assertViewHas('item');
    }
}
