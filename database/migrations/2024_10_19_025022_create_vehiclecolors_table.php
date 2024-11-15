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
        Schema::create('vehiclecolors', function (Blueprint $table) {
            $table->id();
            $table->string("name", 100);
            $table->integer("red")->unsigned()->default(0);    // Valor de rojo (0-255)
            $table->integer("green")->unsigned()->default(0);  // Valor de verde (0-255)
            $table->integer("blue")->unsigned()->default(0);   // Valor de azul (0-255)
            $table->text("description")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiclecolors');
    }
};
