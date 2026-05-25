<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Disiplin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisiplinTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        \Spatie\Permission\Models\Role::create(['name' => 'Guru BK']);
        \Spatie\Permission\Models\Role::create(['name' => 'Waka Kesiswaan']);
        
        $this->user = User::factory()->create();
        $this->user->assignRole('Guru BK');
    }

    /** @test */
    public function test_admin_can_add_discipline_record()
    {
        $this->actingAs($this->user);
        $siswa = Siswa::factory()->create();

        $response = $this->post(route('disiplin.store'), [
            'siswa_id' => $siswa->id,
            'tanggal' => now()->format('Y-m-d'),
            'masalah' => 'Terlambat masuk kelas',
            'keterangan' => 'Diberikan teguran lisan',
        ]);

        $response->assertRedirect(route('disiplin.index'));
        $response->assertSessionHas('success', 'Data Pelanggaran Berhasil Dilaporkan');

        $this->assertDatabaseHas('disiplins', [
            'siswa_id' => $siswa->id,
            'masalah' => 'Terlambat masuk kelas',
        ]);
    }

    /** @test */
    public function test_admin_can_view_print_discipline_data()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('disiplin.show'), [
            'month' => now()->format('Y-m'),
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('cetak.cetak-disiplin');
        $response->assertViewHas('disiplin');
    }
}
