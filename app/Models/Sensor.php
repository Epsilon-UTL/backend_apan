<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $table = 'sensor';
    protected $fillable = [ 'valor', 'tipoSensor_id', 'usuario_id'];

    public function tipoSensor()
    {
        return $this->belongsTo(TipoSensor::class, 'tipoSensor_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function reportes()
    {
        return $this->hasMany(Reporte::class);
    }
}