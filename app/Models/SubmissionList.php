<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionList extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_name',
        'email',
        'nohp',
        'namappat',
        'nosertifikat',
        'latitude',
        'longitude',
        'luastanah',
        'luasbangunan',
        'listrik',
        'tahundibangun',
        'fotoobjek',
        'sertifikat',
        'sppt',
        'bidang',
        'reason',
        'vehicle_id',
        'note',
        'start_date',
        'end_date',
        'approve_by',
        'status',
        'created_at',
        'updated_at',
    ];
    public function approval(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approve_by');
    }
}
