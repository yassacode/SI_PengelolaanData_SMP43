<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        "asal_paud",
        "asal_tk",
        "asal_sd",
        "jrk_sklh"
        ];
}
