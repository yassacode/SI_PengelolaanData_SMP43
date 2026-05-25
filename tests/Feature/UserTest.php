<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        \Spatie\Permission\Models\Role::create(['name' => 'Admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('Admin');
    }

    /** @test */
    public function test_admin_can_add_new_user()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('user.store'), [
            'nama' => 'New User Test',
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'jabatan' => 'Guru',
            'nip' => '1987654321',
            'no_hp' => '08987654321',
            'alamat' => 'Jl. Baru No. 2',
        ]);

        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('success', 'Data Berhasil Ditambahkan');

        $this->assertDatabaseHas('users', [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
        ]);
    }
}
