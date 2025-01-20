<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pihak extends Model
{
    protected $table = 'pihak';
    // Primary key
    protected $primaryKey = 'id';
    protected $fillable = [
        'pihak'
    ];
}
