<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'kegiatan1',
        'juara1',
        'kegiatan2',
        'juara2',
        'kegiatan3',
        'juara3',
        'kegiatan4',
        'juara4',
        'kegiatan5',
        'juara5',
    ];
}
