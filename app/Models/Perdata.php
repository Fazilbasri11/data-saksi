<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perdata extends Model
{
    protected $table = 'perdata';
    // Primary key
    protected $primaryKey = 'id';
    protected $fillable = [
        'jenis'
    ];
}
