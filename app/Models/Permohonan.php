<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'nomordokumen', 'nama_wp', 'alamat_wp', 'nop', 'alamat_objek', 'tujuan', 'dokumen', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal()
{
    return $this->hasOne(Jadwal::class);
}

}
