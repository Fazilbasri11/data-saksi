<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJenisPihak extends Model
{
    use HasFactory;
    protected $table = 'data_jenis_pihak';
    // Primary key
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_jenis_pihak',
        'nama'
    ];

    public function jenispihak()
    {
        return $this->belongsTo(JenisPihak::class, 'id_jenis_pihak', 'id');
    }
}
