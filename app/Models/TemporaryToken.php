<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
        'is_used'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean'
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Verifica si el token ha expirado
     */
    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    /**
     * Marca el token como usado
     */
    public function markAsUsed()
    {
        $this->is_used = true;
        $this->save();
    }
}