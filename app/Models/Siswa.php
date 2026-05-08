<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wali()
    {
        return $this->belongsTo(Wali::class);
    }

    public function akademik()
    {
        return $this->hasOne(Akademik::class);
    }

    public function kesehatan()
    {
        return $this->hasOne(Kesehatan::class);
    }

    public function prestasis()
    {
        return $this->hasMany(Prestasi::class);
    }

    public function disiplins()
    {
        return $this->hasMany(Disiplin::class);
    }

    public function ekstrakurikulers()
    {
        return $this->belongsToMany(Ekstrakurikuler::class, 'anggota_ekskuls');
    }
}
