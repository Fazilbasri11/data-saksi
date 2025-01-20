<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPerkara extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'status_perkara';

    // Primary key
    protected $primaryKey = 'id';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'status',
    ];

    // Timestamps
    public $timestamps = false;

    // Relasi ke tabel saksi
    public function saksi()
    {
        return $this->hasMany(Saksi::class, 'id_status_perkara');
    }
}
