<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "student_id",
        "masalah",
        "kelas",
        "tanggal",
        "foto",
        "solusi",
        "keterangan",
        "status"
    ];
    
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
