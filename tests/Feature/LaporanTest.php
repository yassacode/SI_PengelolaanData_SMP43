<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Disiplin;
use App\Models\PengesahanLaporan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        \Spatie\Permission\Models\Role::create(['name' => 'Kepala Sekolah']);
        \Spatie\Permission\Models\Role::create(['name' => 'Waka Kesiswaan']);
        $this->kepsek = User::factory()->create();
        $this->kepsek->assignRole('Kepala Sekolah');
    }

    /** @test */
    public function test_kepsek_can_view_pengesahan_laporan()
    {
        $this->actingAs($this->kepsek);

        // Create some approved discipline data to trigger record generation
        Disiplin::factory()->create([
            'status_validasi' => Disiplin::STATUS_APPROVED,
            'tanggal' => now()->format('Y-m-d')
        ]);

        $response = $this->get(route('laporan.index'));

        $response->assertStatus(200);
        $response->assertViewIs('kepsek.pengesahan-laporan');
        $response->assertViewHas('laporans');
        
        $this->assertDatabaseHas('pengesahan_laporans', [
            'jenis_laporan' => 'Kedisiplinan',
            'periode' => now()->format('Y-m')
        ]);
    }

    /** @test */
    public function test_kepsek_can_approve_laporan()
    {
        $this->actingAs($this->kepsek);

        $laporan = PengesahanLaporan::create([
            'jenis_laporan' => 'Kedisiplinan',
            'periode' => now()->format('Y-m'),
            'status_kepsek' => Disiplin::STATUS_PENDING
        ]);

        $response = $this->patch(route('laporan.approve', $laporan->id));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Laporan berhasil disahkan.');

        $this->assertDatabaseHas('pengesahan_laporans', [
            'id' => $laporan->id,
            'status_kepsek' => Disiplin::STATUS_APPROVED
        ]);
    }
}
