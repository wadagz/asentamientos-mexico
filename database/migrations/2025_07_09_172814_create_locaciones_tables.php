<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Wadagz\AsentamientosMexico\Enums\Asentamiento\TipoAsentamientoEnum;
use Wadagz\AsentamientosMexico\Enums\Asentamiento\TipoZonaEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
        });

        Schema::create('municipios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estado_id')->constrained('estados');
            $table->string('nombre');
        });

        Schema::create('asentamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estado_id')->constrained('estados');
            $table->foreignId('municipio_id')->nullable()->constrained('municipios')->nullOnDelete();
            $table->string('nombre');
            $table->enum('tipo_asentamiento', TipoAsentamientoEnum::values());
            $table->string('ciudad');
            $table->string('codigo_postal', 5);
            $table->enum('tipo_zona', TipoZonaEnum::values());
            $table->bigInteger('id_interno_municipio'); // id interno usado dentro del municipio
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados');
        Schema::dropIfExists('municipios');
        Schema::dropIfExists('asentamientos');
    }
};
