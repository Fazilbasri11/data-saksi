<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPerkara extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'jenis_perkara';

    // Primary key
    protected $primaryKey = 'id';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'jenis',
    ];

    // Timestamps
    public $timestamps = false;

    // Relasi ke tabel Saksi
    public function saksi()
    {
        return $this->hasMany(Saksi::class, 'id_jenis_perkara');
    }
}
