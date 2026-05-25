<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Wali;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create necessary roles
        \Spatie\Permission\Models\Role::create(['name' => 'Staff Kesiswaan']);
        \Spatie\Permission\Models\Role::create(['name' => 'Guru']);
        \Spatie\Permission\Models\Role::create(['name' => 'Waka Kesiswaan']);
        \Spatie\Permission\Models\Role::create(['name' => 'Kepala Sekolah']);
        \Spatie\Permission\Models\Role::create(['name' => 'Admin']);
        \Spatie\Permission\Models\Role::create(['name' => 'Guru BK']);

        $this->user = User::factory()->create();
        $this->user->assignRole('Staff Kesiswaan');
    }

    /** @test */
    public function test_admin_can_add_student_step_by_step()
    {
        $this->actingAs($this->user);

        // Step 1: Store in session
        $response = $this->post(route('siswa.store1'), [
            'nisn' => '1234567890',
            'nama' => 'Student Test',
            'ttl' => 'Jakarta, 2005-01-01',
            'agama' => 'Islam',
            'hobi' => 'Membaca',
            'thn_msk' => '2023',
            'alamat' => 'Jl. Test No. 1',
            'tb' => '170',
            'bb' => '60',
        ]);

        $response->assertRedirect(route('siswa.create2'));
        $this->assertNotNull(session('siswa_step1'));

        // Step 2: Store in session
        $response = $this->post(route('siswa.store2'), [
            'asal_paud' => 'Paud Test',
            'asal_tk' => 'TK Test',
            'asal_sd' => 'SD Test',
            'jrk_sklh' => '2km',
            'beasiswa' => 'Tidak Ada',
            'sakit' => 'Tidak Ada',
            'kegiatan1' => 'Lomba Test',
            'juara1' => 'Juara 1',
        ]);

        $response->assertRedirect(route('siswa.create3'));
        $this->assertNotNull(session('siswa_step2'));

        // Step 3: Store in database
        $response = $this->post(route('siswa.store'), [
            'nama_ayah' => 'Ayah Test',
            'nama_ibu' => 'Ibu Test',
            'pekerjaan_ayah' => 'PNS',
            'pekerjaan_ibu' => 'IRT',
            'alamat_ayah' => 'Jl. Test No. 1',
            'alamat_ibu' => 'Jl. Test No. 1',
            'no_hp_ayah' => '08123456789',
            'no_hp_ibu' => '08123456789',
        ]);

        $response->assertRedirect(route('siswa.index'));
        $response->assertSessionHas('success', 'Data Siswa Berhasil Ditambahkan');

        $this->assertDatabaseHas('siswas', ['nama' => 'Student Test']);
        $this->assertDatabaseHas('walis', ['nama_ayah' => 'Ayah Test']);
    }

    /** @test */
    public function test_admin_can_view_print_student_data()
    {
        $this->actingAs($this->user);
        
        $wali = Wali::factory()->create();
        $siswa = Siswa::factory()->create(['wali_id' => $wali->id]);

        $response = $this->get(route('siswa.show2', $siswa->id));

        $response->assertStatus(200);
        $response->assertViewIs('cetak.cetak-siswa');
        $response->assertViewHas('student');
    }
}
