<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    //
    use HasFactory;
    
    protected $table = 'reportes';
    protected $fillable = ['sensor_id','usuario_id','descripcion','estatus_id','fecha'];

    public function Sensor()
    {
        return $this->belongsTo( Sensor::class);
    }

    public function Users()
    {
        return $this->belongsTo(User::class);
    }

    public function EstatusReporte()
    {
        return $this->belongsTo(EstatusReporte::class);
    }
}
