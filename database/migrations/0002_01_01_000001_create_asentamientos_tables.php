<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->timestamps();
        });

        Schema::create('asentamientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('municipio_id')->nullable()->constrained('municipios')->nullOnDelete();
            $table->string('nombre');
            $table->string('tipo_asentamiento');
            $table->string('ciudad')->nullable();
            $table->string('codigo_postal', 5);
            $table->string('tipo_zona');
            $table->timestamps();
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
