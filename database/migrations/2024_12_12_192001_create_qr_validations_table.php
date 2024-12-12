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
        Schema::create('qr_validations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id'); // Foreign key to file entries
            $table->string('url'); // The generated QR validation URL
            $table->timestamp('scanned_at')->nullable(); // When it was scanned
            $table->boolean('is_valid')->default(true);

            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_validations');
    }
};
