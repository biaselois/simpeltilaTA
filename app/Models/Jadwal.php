<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals'; // Nama tabel di database

    protected $fillable = [
        'permohonan_id',
        'tanggal_tinjau',
        'lokasi',
        'petugas_id',
        'status',
        // tambahkan field lain sesuai kebutuhan
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }
    public function petugas()
{
    return $this->belongsToMany(User::class, 'jadwal_petugas');
}

 public function beritaAcara()
    {
        return $this->hasOne(BeritaAcara::class);
    }

}
