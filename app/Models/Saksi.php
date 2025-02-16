<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saksi extends Model
{
    use HasFactory;

    // Nama tabel jika tidak mengikuti konvensi plural
    protected $table = 'saksi';

    // Primary key jika berbeda dari 'id'
    protected $primaryKey = 'id';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id_jenis_perkara',
        'id_status_perkara',
        'id_pihak',
        'id_perdata',
        'id_no_perkara',
        'tgl_kehadiran',
        'akan_hadir',
        'nama_saksi',
        'tempat_lahir',
        'tanggal_lahir',
        'id_jeniskelamin',
        'alamat',
        'no_hp',
        'izin',
    ];

    // Kolom yang harus dianggap sebagai tanggal
    protected $dates = [
        'tgl_kehadiran',
        'tanggal_lahir',
    ];

    // Jika tabel menggunakan kolom timestamps (created_at, updated_at)
    public $timestamps = true;

    // Relasi ke tabel lainnya (contoh, jika ada tabel jenis_perkara atau status_perkara)
    public function jenisPerkara()
    {
        return $this->belongsTo(JenisPerkara::class, 'id_jenis_perkara');
    }

    public function statusPerkara()
    {
        return $this->belongsTo(StatusPerkara::class, 'id_status_perkara');
    }

    public function pihak()
    {
        return $this->belongsTo(Pihak::class, 'id_pihak');
    }

    public function perdata()
    {
        return $this->belongsTo(Perdata::class, 'id_perdata');
    }

    public function jenisKelamin()
    {
        return $this->belongsTo(JenisKelamin::class, 'id_jeniskelamin');
    }

    public function izin()
    {
        return $this->belongsTo(Izin::class, 'id_izin');
    }

    public function noPerkara()
    {
        return $this->belongsTo(NoPerkaraPerdata::class, 'id_no_perkara');
    }
}
