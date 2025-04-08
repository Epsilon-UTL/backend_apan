<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    use HasFactory;

    protected $table = 'unidad_medida';
    protected $fillable = ['unidadMedida'];

    public function sensors()
    {
        return $this->hasMany(Sensor::class, 'unidadMedida_id');
    }
}
