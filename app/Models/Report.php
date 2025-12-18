<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','category_id','judul','tipe','deskripsi','lokasi','foto','status','claimed_by','claimed_at','bukti_klaim','catatan_klaim','pelapor_approval','pelapor_approved_at','confirmed_by','confirmed_at'];

    protected $casts = [
        'foto' => 'array',
        'bukti_klaim' => 'array',
        'claimed_at' => 'datetime',
        'pelapor_approved_at' => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
