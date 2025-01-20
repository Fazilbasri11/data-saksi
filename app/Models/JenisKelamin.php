<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKelamin extends Model
{
    use HasFactory;

    // Nama tabel jika tidak sesuai konvensi plural Laravel
    protected $table = 'jenis_kelamin';

    // Primary key jika berbeda dari 'id'
    protected $primaryKey = 'id';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'jenis',
    ];

    // Timestamps
    public $timestamps = false;

    // Relasi ke tabel saksi
    public function saksi()
    {
        return $this->hasMany(Saksi::class, 'id_jeniskelamin');
    }
}
