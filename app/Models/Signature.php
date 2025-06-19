<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'nip',
        'nik',
        'qrcode',
        'ttd',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
