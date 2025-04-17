<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    // Tentukan fields yang dapat diisi
    protected $fillable = ['name', 'email', 'phone', 'address','instansi', 'message'];
}

