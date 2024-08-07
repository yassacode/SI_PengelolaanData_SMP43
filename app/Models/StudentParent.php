<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    use HasFactory;

    protected $fillable = [
        "nama_ayah",
        "nama_ibu",
        "nama_wali",
        "pekerjaan_ayah",
        "pekerjaan_ibu",
        "pekerjaan_wali",
        "alamat_ayah",
        "alamat_ibu",
        "alamat_wali",
        "no_hp_ayah",
        "no_hp_ibu",
        "no_hp_wali",
        "identitas_wali"
        ];
}
