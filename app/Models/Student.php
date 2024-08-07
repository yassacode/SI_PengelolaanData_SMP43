<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        "school_id",
        "student_parent_id",
        "sibling_id",
        "history_id",
        "user_id",
        "achievement_id",
        "nama",
        "nisn",
        "ttl",
        "alamat",
        "no_hp",
        "tb",
        "bb",
        "hobi",
        "agama",
        "thn_msk",
        "status"
        ];
}
