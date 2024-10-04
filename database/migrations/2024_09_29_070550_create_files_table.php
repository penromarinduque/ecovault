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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file_path');
            $table->string('category')->nullable();
            $table->string('classification')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tree_cutting_permits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade');  // Connect to files table
            $table->string('name_of_client');
            $table->integer('number_of_trees');
            $table->string('species');
            $table->string('location');
            $table->date('date_applied');
            $table->timestamps();
        });

        Schema::create('chainsaw_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade');  // Connect to files table
            $table->string('name_of_client');
            $table->string('location');
            // $table->string('serial_number');
            $table->date('date_applied');
            $table->timestamps();
        });

        Schema::create('tree_plantation_registration', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade');  // Connect to files table
            $table->string('name_of_client');
            $table->string('location');
            $table->date('date_applied');
            $table->timestamps();
        });

        Schema::create('transport_permits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade');  // Connect to the files table
            $table->string('name_of_client');  // Name of the client
            $table->integer('number_of_trees');  // Number of trees
            $table->string('species');  // Species of trees
            $table->date('date_applied');  // Date of application
            $table->date('date_of_transport');  // Date of transport
            $table->timestamps();
        });

        Schema::create('land_titles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade');  // Connect to the files table
            $table->string('name_of_client');  // Name of the client
            $table->string('location');  // Location of the property
            $table->string('lot_number');  // Lot number
            $table->string('property_category');  // Property category (residential, agricultural, special)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_titles');
        Schema::dropIfExists('transport_permits');
        Schema::dropIfExists('tree_plantation_registration');
        Schema::dropIfExists('chainsaw_registrations');
        Schema::dropIfExists('tree_cutting_permits');
        Schema::dropIfExists('files');
    }
};
