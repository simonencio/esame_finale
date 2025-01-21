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
        Schema::create('nazioni', function (Blueprint $table) {
            $table->id("idNazione");
            $table->string('nome', 45)->index();
            $table->string('continente', 45);
            $table->char('iso', 2);
            $table->char('iso3', 3);
            $table->string('prefissoTelefonico', 45);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nazioni');
    }
};
