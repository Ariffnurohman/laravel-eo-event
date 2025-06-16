<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'lokasi',
        'jenis',
        'waktu_mulai',
        'waktu_selesai',
        'kuota',
        'mengeluarkan_sertifikat',
        'form_pendaftaran',
        'is_active',
        'foto',
    ];

    protected $casts = [
        'form_pendaftaran' => 'array',
        'mengeluarkan_sertifikat' => 'boolean',
        'is_active' => 'boolean',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function peserta()
    {
        return $this->hasMany(\App\Models\Participant::class);
    }


}