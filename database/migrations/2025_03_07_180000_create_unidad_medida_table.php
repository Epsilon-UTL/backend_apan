<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadMedidaTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('unidad_medida')) { return; }
        Schema::create('unidad_medida', function (Blueprint $table) {
            $table->id();
            $table->text('unidadMedida');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unidad_medida');
    }
}