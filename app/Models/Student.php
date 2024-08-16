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

        public function history()
    {
        return $this->belongsTo(History::class, 'history_id');
    }
        public function achievement()
    {
        return $this->belongsTo(Achievement::class, 'achievement_id');
    }
        public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
        public function sibling()
    {
        return $this->belongsTo(Sibling::class, 'sibling_id');
    }
        public function studentparent()
    {
        return $this->belongsTo(StudentParent::class, 'student_parent_id');
    }
        public function dicipline()
    {
        return $this->hasMany(Discipline::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
