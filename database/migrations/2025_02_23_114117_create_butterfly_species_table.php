<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('butterfly_species', function (Blueprint $table) {
            $table->id();
            $table->string('scientific_name');
            $table->string('common_name')->nullable();
            $table->string('family')->nullable();
            $table->string('genus')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('butterfly_species');
    }
};
