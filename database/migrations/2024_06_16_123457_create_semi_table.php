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
        Schema::create('semi', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('contestantID')->nullable();
            $table->unsignedInteger('beauty')->nullable();
            $table->unsignedInteger('poise')->nullable();
            $table->unsignedInteger('projection')->nullable();
            $table->unsignedInteger('eventID')->nullable();
            $table->string('judgesCode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semi');
    }
};
