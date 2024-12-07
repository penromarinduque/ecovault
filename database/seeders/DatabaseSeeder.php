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
            ['type_name' => 'tree-cutting-permits', 'classification_id' => 1],
            ['type_name' => 'chainsaw-registration', 'classification_id' => 1],
            [
                'type_name' => 'tree-plantation-registration',
                'classification_id' => 1
            ],
            ['type_name' => 'transport-permit', 'classification_id' => 1],
            ['type_name' => 'land-title', 'classification_id' => 1],
            ['type_name' => 'memoranda', 'classification_id' => 2],
            ['type_name' => 'letters', 'classification_id' => 2],
            ['type_name' => 'special-orders', 'classification_id' => 2],
            ['type_name' => 'reports', 'classification_id' => 2],
        ];


        foreach ($fileTypes as $fileType) {
            FileType::updateOrCreate(
                ['type_name' => $fileType['type_name']], // Find by type_name
                ['classification_id' => $fileType['classification_id']] // Set classification_id
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
