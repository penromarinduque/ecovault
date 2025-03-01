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
            $table->string('permit_type')->nullable();
            $table->string('land_category')->nullable();
            $table->string('municipality')->nullable();
            $table->string('report_type')->nullable();
            $table->string(column: 'file_name');
            $table->string('file_path');
            $table->string('office_source');
            $table->string('classification');
            $table->date('date_released')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamp('archived_at')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tree_cutting_permits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade'); // Connect to files table
            $table->string('name_of_client');
            $table->timestamps();
        });


        // Tree cutting permit details table
        Schema::create('tree_cutting_permit_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tree_cutting_permit_id')->constrained('tree_cutting_permits')->onDelete('cascade');
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
            $table->string('serial_number');
            $table->date('date_applied');
            $table->timestamps();
        });

        Schema::create('tree_plantation_registration', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade');  // Connect to files table
            $table->string('name_of_client');
            $table->integer('number_of_trees');
            $table->string('location');
            $table->date('date_applied');
            $table->timestamps();
        });

        Schema::create('transport_permits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade');  // Connect to the files table
            $table->string('name_of_client');  // Name of the client
            $table->timestamps();
        });

        // tree_transport_details
        Schema::create('tree_transport_permit_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transport_permit_id')->constrained('transport_permits')->onDelete('cascade');
            $table->integer('number_of_trees');
            $table->string('species');
            $table->string('destination');
            $table->date('date_of_transport');  // Date of transport
            $table->date('date_applied');
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

        Schema::create('local_transport_permits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('files')->onDelete('cascade'); // Connect to files table
            $table->string('name_of_client');
            $table->string('business_farm_name');
            $table->string('butterfly_permt_number');
            $table->string('destination');
            $table->date('date_applied');
            $table->string('classification');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_titles');
        Schema::dropIfExists('tree_transport_permit_details');
        Schema::dropIfExists('transport_permits');
        Schema::dropIfExists('tree_cutting_permit_details');
        Schema::dropIfExists('tree_plantation_registration');
        Schema::dropIfExists('chainsaw_registrations');
        Schema::dropIfExists('tree_cutting_permits');
        Schema::dropIfExists('files');
    }
};
