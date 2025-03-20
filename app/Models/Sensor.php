<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $table = 'sensor';
    protected $fillable = ['unidadMedida_id', 'valor', 'tipoSensor_id', 'fecha'];

    public function unidadMedida()
    {
        return $this->belongsTo(UnidadMedida::class, 'unidadMedida_id');
    }

    public function tipoSensor()
    {
        return $this->belongsTo(TipoSensor::class, 'tipoSensor_id');
    }
}