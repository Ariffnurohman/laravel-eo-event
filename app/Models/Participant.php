<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'form_data',
        'status_kehadiran',
        'qr_code_path',
        'bukti_pembayaran',
    ];

    protected $casts = [
        'form_data' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function certificate()
    {
        return $this->hasOne(\App\Models\Certificate::class);
    }

}

