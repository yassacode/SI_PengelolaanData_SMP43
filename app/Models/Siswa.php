<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wali(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Wali::class);
    }

    public function akademik(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Akademik::class);
    }

    public function kesehatan(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Kesehatan::class);
    }

    public function prestasis(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Prestasi::class);
    }

    public function disiplins(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Disiplin::class);
    }

    public function ekstrakurikulers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Ekstrakurikuler::class, 'anggota_ekskuls');
    }

    public function masterEkskuls(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(MasterEkskul::class, 'siswa_master_ekskul', 'siswa_id', 'master_ekskul_id');
    }
}
