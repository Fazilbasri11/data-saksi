<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoPerkaraPerdata extends Model
{
    use HasFactory;
    protected $table = 'no_perkara';
    // Primary key
    protected $primaryKey = 'id';
    protected $fillable = [
        'no'
    ];
}
