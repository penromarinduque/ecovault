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
        DB::unprepared('
            DROP PROCEDURE IF EXISTS ManageButterflySpecies;          

            CREATE PROCEDURE ManageButterflySpecies(
                IN actionType VARCHAR(10),
                IN speciesId INT,
                IN scientificName VARCHAR(255),
                IN commonName VARCHAR(255),
                IN family VARCHAR(255),
                IN genus VARCHAR(255),
                IN description TEXT,
                IN imageUrl VARCHAR(255)
            )
            BEGIN
                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    ROLLBACK;
                END;

                START TRANSACTION;

                IF actionType = "CREATE" THEN
                    INSERT INTO butterfly_species (scientific_name, common_name, family, genus, description, image_url, created_at, updated_at)
                    VALUES (scientificName, commonName, family, genus, description, imageUrl, NOW(), NOW());

                ELSEIF actionType = "READ" THEN
                    SELECT * FROM butterfly_species WHERE id = speciesId;

                ELSEIF actionType = "UPDATE" THEN
                    UPDATE butterfly_species
                    SET scientific_name = scientificName,
                        common_name = commonName,
                        family = family,
                        genus = genus,
                        description = description,
                        image_url = imageUrl,
                        updated_at = NOW()
                    WHERE id = speciesId;

                ELSEIF actionType = "DELETE" THEN
                    DELETE FROM butterfly_species WHERE id = speciesId;

                ELSE
                    SIGNAL SQLSTATE "45000" SET MESSAGE_TEXT = "Invalid action type.";
                END IF;

                COMMIT;
            END;

           
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS ManageButterflySpecies');
    }
};
