<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sensor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unidadMedida_id')->constrained('unidad_medida')->onDelete('cascade');
            $table->foreignId('tipoSensor_id')->constrained('tipo_sensor')->onDelete('cascade');
            $table->decimal('valor', 10, 2);
            $table->timestamp('fecha');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sensor');
    }
}; 