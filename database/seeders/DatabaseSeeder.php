<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Municipality;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Config;
use App\Models\FileType;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $faker = Faker::create();
        $this->call(AdminSeeder::class);

        User::factory(count: 10)->create();

        User::factory()->create([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'isAdmin' => false,
            'employee_id' => Str::random(6),
            'email_verified_at' => Carbon::now(),
            'otp' => random_int(100000, 999999),
            'password' => Hash::make('password'),
        ]);
        $fileTypes = [
            ['group_name' => 'Forestry', 'type_name' => 'tree-cutting-permits', 'classification_id' => 1, 'folder_name' => 'Tree Cutting Permits'],
            ['group_name' => 'Forestry', 'type_name' => 'chainsaw-registration', 'classification_id' => 1, 'folder_name' => 'Chainsaw Registration'],
            ['group_name' => 'Forestry', 'type_name' => 'tree-plantation-registration', 'classification_id' => 1, 'folder_name' => 'Private Tree Plantation Registration'],
            ['group_name' => 'Forestry', 'type_name' => 'transport-permit', 'classification_id' => 1, 'folder_name' => 'Tree Transport Permit'],
            ['group_name' => 'Lands', 'type_name' => 'land-title', 'classification_id' => 1, 'folder_name' => 'Land Titles / Patented Lots'],
            ['group_name' => 'Biodiversity', 'type_name' => 'local-transport-permit', 'classification_id' => 1, 'folder_name' => 'Local Transport Permits'],
            ['group_name' => 'Adminstrative', 'type_name' => 'memoranda', 'classification_id' => 2, 'folder_name' => 'Memoranda'],
            ['group_name' => 'Adminstrative', 'type_name' => 'letters', 'classification_id' => 2, 'folder_name' => 'Letters'],
            ['group_name' => 'Adminstrative', 'type_name' => 'special-orders', 'classification_id' => 2, 'folder_name' => 'Special Orders'],
            ['group_name' => 'Adminstrative', 'type_name' => 'reports', 'classification_id' => 2, 'folder_name' => 'Reports'],
        ];

        foreach ($fileTypes as $fileType) {
            FileType::updateOrCreate(
                ['type_name' => $fileType['type_name']], // Find by type_name
                [
                    'group_name' => $fileType['group_name'],
                    'classification_id' => $fileType['classification_id'],
                    'folder_name' => $fileType['folder_name']
                ] // Set or update values
            );
        }



        Municipality::insert([
            ['location' => 'Mogpog', 'img_src' => 'images/folders/mogpog.png'],
            ['location' => 'Torrijos', 'img_src' => 'images/folders/torrijos.png'],
            ['location' => 'Boac', 'img_src' => 'images/folders/boac.png'],
            ['location' => 'Gasan', 'img_src' => 'images/folders/gasan.png'],
            ['location' => 'Buenavista', 'img_src' => 'images/folders/buenavista.png'],
            ['location' => 'Santa Cruz', 'img_src' => 'images/folders/staCruz.png'],
        ]);

        Config::create([
            'Drive' => 'C:',
            'BackDirSQL' => '/backup/sql',
            'BackDirFiles' => '/backup/files',
            'StorePath' => 'app/public/PENRO',
            'MySqlDir' => 'C:\\\\xampp\\\\mysql\\\\bin\\\\mysql.exe',
            'MySqlDumpDir' => 'C:\\\\xampp\\\\mysql\\\\bin\\\\mysqldump.exe'
        ]);


    }
}
