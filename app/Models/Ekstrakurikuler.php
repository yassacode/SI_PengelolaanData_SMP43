<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'anggota_ekskuls');
    }

    public function pembina()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
