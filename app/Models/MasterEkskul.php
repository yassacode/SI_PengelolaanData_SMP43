<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MasterEkskul extends Model
{
    use HasFactory;

    protected $table = 'master_ekskuls';
    protected $guarded = ['id'];

    /**
     * Get activities for this ekskul.
     */
    public function kegiatan(): HasMany
    {
        return $this->hasMany(Ekstrakurikuler::class, 'master_ekskul_id');
    }

    /**
     * Get students following this ekskul.
     */
    public function siswas(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'siswa_master_ekskul', 'master_ekskul_id', 'siswa_id');
    }
}
