<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Membuat Roles
        $roles = [
            'Admin',
            'Staff Kesiswaan',
            'Guru',
            'Guru BK',
            'Waka Kesiswaan',
            'Kepala Sekolah'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // 2. Membuat Users dan Menetapkan Role

        // User Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@sekolah.com'],
            [
                'nama' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('password123'),
                'jabatan' => 'IT Support',
                'nip' => '10000001',
                'no_hp' => '081234567890',
            ]
        );
        $admin->assignRole('Admin');

        // User Staff Kesiswaan
        $staff = User::firstOrCreate(
            ['email' => 'staff@sekolah.com'],
            [
                'nama' => 'Staff Kesiswaan',
                'username' => 'staff',
                'password' => Hash::make('password123'),
                'jabatan' => 'Staff TU',
                'nip' => '10000002',
            ]
        );
        $staff->assignRole('Staff Kesiswaan');

        // User Guru
        $guru = User::firstOrCreate(
            ['email' => 'guru@sekolah.com'],
            [
                'nama' => 'Bapak Guru',
                'username' => 'guru',
                'password' => Hash::make('password123'),
                'jabatan' => 'Guru Mata Pelajaran',
                'nip' => '10000003',
            ]
        );
        $guru->assignRole('Guru');

        // User Guru BK
        $gurubk = User::firstOrCreate(
            ['email' => 'gurubk@sekolah.com'],
            [
                'nama' => 'Ibu Guru BK',
                'username' => 'gurubk',
                'password' => Hash::make('password123'),
                'jabatan' => 'Guru Bimbingan Konseling',
                'nip' => '10000004',
            ]
        );
        $gurubk->assignRole('Guru BK');

        // User Waka Kesiswaan
        $waka = User::firstOrCreate(
            ['email' => 'waka@sekolah.com'],
            [
                'nama' => 'Bapak Waka Kesiswaan',
                'username' => 'waka',
                'password' => Hash::make('password123'),
                'jabatan' => 'Wakil Kepala Sekolah',
                'nip' => '10000005',
            ]
        );
        $waka->assignRole('Waka Kesiswaan');

        // User Kepala Sekolah
        $kepsek = User::firstOrCreate(
            ['email' => 'kepsek@sekolah.com'],
            [
                'nama' => 'Bapak Kepala Sekolah',
                'username' => 'kepsek',
                'password' => Hash::make('password123'),
                'jabatan' => 'Kepala Sekolah',
                'nip' => '10000006',
            ]
        );
        $kepsek->assignRole('Kepala Sekolah');

        // User dengan Multiple Roles (Contoh: Admin & Guru)
        $multi = User::firstOrCreate(
            ['email' => 'superguru@sekolah.com'],
            [
                'nama' => 'Super Guru (Multi Role)',
                'username' => 'superguru',
                'password' => Hash::make('password123'),
                'jabatan' => 'Guru & IT',
                'nip' => '10000007',
            ]
        );
        $multi->assignRole(['Admin', 'Guru']);
    }
}
