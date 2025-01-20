<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    protected $table = 'status_izin';
    // Primary key
    protected $primaryKey = 'id';
    protected $fillable = [
        'jenis'
    ];
}