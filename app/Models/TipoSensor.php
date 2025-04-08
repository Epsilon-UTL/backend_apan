<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSensor extends Model
{
    use HasFactory;

    protected $table = 'tipo_sensor';
    protected $fillable = ['nombreSensor','unidadMedida_id'];

    public function sensors()
    {
        return $this->hasMany(Sensor::class, 'tipoSensor_id');
    }

    public function unidadMedida()
    {
        return $this->hasMany(UnidadMedida::class,'id');
    }
}