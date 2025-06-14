<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'file_path',
        'verification_token',
    ];
    
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

}