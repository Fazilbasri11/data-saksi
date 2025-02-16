<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PihakMenghadirkan extends Model
{
    use HasFactory;
    protected $table = 'data_pihak';
    // Primary key
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_pihak',
        'nama'
    ];

    public function pihak()
    {
        return $this->belongsTo(Pihak::class, 'id_pihak');
    }
}
