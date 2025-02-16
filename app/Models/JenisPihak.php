<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPihak extends Model
{
    use HasFactory;
    protected $table = 'jenis_pihak';
    // Primary key
    protected $primaryKey = 'id';
    protected $fillable = [
        'jenis'
    ];
}
