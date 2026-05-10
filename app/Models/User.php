<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function siswas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Siswa::class);
    }

    public function disiplins(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Disiplin::class, 'user_id');
    }

    public function ekstrakurikulers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ekstrakurikuler::class, 'user_id');
    }
}
