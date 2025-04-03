<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSensor extends Model
{
    use HasFactory;

    protected $table = 'tipo_sensor';
    protected $fillable = ['nombreSensor'];

    public function sensors()
    {
        return $this->hasMany(Sensor::class, 'tipoSensor_id');
    }
}