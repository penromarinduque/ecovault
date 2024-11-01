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
        Schema::create('file_access_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade');
            $table->foreignId('requested_by_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('handled_by_admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('requested_permission', ['viewer', 'editor', 'admin'])->default('viewer');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_access_requests');
    }
};
