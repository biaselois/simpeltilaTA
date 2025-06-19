<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaAcara extends Model
{
    use HasFactory;


    protected $table = 'berita_acaras'; // nama tabel (jamak, sesuai konvensi)

    protected $fillable = [
        'jadwal_id',
        'tanggal',
        'Nama_WP',
        'Alamat_WP',
        'NOP',
        'Alamat_OP',
        'Tujuan',
        'Hasil',
        'Rekomendasi',
        'dokumentasi',
        'Signature_WP',
        'Validasi_Kasi',
        'Validasi_Kabid',
    ];

    // Relasi ke Jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function permohonan()
{
    return $this->belongsTo(Permohonan::class);
}




    // Relasi ke User (petugas/pengisi berita acara)

//     public function petugas()
// {
//     return $this->belongsToMany(User::class, 'berita_acara_petugas');
// }
}
