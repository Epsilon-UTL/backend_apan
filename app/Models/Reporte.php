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

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function estatusReporte()
    {
        return $this->belongsTo(EstatusReporte::class, 'estatus_id');
    }
}
