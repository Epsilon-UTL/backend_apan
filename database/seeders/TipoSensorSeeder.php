<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidadPh = DB::table('unidad_medida')->where('unidadMedida', 'pH')->first();
        $unidadNTU = DB::table('unidad_medida')->where('unidadMedida', 'NTU')->first();
        $unidadCm = DB::table('unidad_medida')->where('unidadMedida', 'cm')->first();

        DB::table('tipo_sensor')->insert([
            ['nombreSensor' => 'Sensor de pH', 'unidadMedida_id' => $unidadPh->id],
            ['nombreSensor' => 'Sensor de Turbidez', 'unidadMedida_id' => $unidadNTU->id],
            ['nombreSensor' => 'Sensor de Nivel de Agua', 'unidadMedida_id' => $unidadCm->id],
        ]);
    }
}
