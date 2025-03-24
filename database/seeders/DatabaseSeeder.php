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
use Illuminate\Support\Arr;

use Illuminate\Support\Facades\DB;
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
            'MySqlDir' => ':\\\\xampp\\\\mysql\\\\bin\\\\mysql.exe',
            'MySqlDumpDir' => 'C:\\\\xampp\\\\mysql\\\\bin\\\\mysqldump.exe'
        ]);

        DB::table('butterfly_species')->insert([
            [
                'scientific_name' => 'Papilio machaon',
                'common_name' => 'Swallowtail Butterfly',
                'family' => 'Papilionidae',
                'genus' => 'Papilio',
                'description' => 'A large, colorful butterfly known for its distinctive tail-like extensions on its hindwings.',
                'image_url' => 'https://example.com/swallowtail.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'scientific_name' => 'Vanessa atalanta',
                'common_name' => 'Red Admiral',
                'family' => 'Nymphalidae',
                'genus' => 'Vanessa',
                'description' => 'A striking black, orange, and white butterfly often found in gardens and woodlands.',
                'image_url' => 'https://example.com/red-admiral.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'scientific_name' => 'Danaus plexippus',
                'common_name' => 'Monarch Butterfly',
                'family' => 'Nymphalidae',
                'genus' => 'Danaus',
                'description' => 'Famous for its long migrations and bright orange wings with black veins.',
                'image_url' => 'https://example.com/monarch.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'scientific_name' => 'Idea leuconoe',
                'common_name' => 'Paper Kite Butterfly',
                'family' => 'Nymphalidae',
                'genus' => 'Idea',
                'description' => 'A large butterfly with delicate black-and-white patterned wings.',
                'image_url' => 'https://example.com/paper-kite.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $permitTypes = [
            'tree-cutting-permits',
            'chainsaw-registration',
            'tree-plantation-registration',
            'transport-permit',
            'land-title',
            'local-transport-permit',
            'memoranda',
            'letters',
            'special-orders'
        ];

        $municipalities = ['Mogpog', 'Torrijos', 'Boac', 'Gasan', 'Buenavista', 'Santa Cruz'];

        //remove
        $files = [];

        for ($i = 1; $i <= 100; $i++) {
            $randomCreatedAt = Carbon::now()->subYears(rand(0, 3))->subMonths(rand(0, 11))->subDays(rand(0, 28));

            $files[] = [
                'permit_type' => Arr::random($permitTypes),
                'category' => Arr::random(['Agricultural', 'Residential', 'Special', null]),
                'municipality' => Arr::random($municipalities),
                'report_type' => Arr::random(['Annual', 'Quarterly', 'Monthly', null]),
                'file_name' => 'document_' . $i . '.pdf',
                'file_path' => 'uploads/documents/document_' . $i . '.pdf',
                'office_source' => Arr::random(['DENR', 'PENRO', 'CENRO', null]),
                'classification' => Arr::random(['Public', 'Confidential', 'Restricted']),
                'date_released' => $i % 2 == 0 ? $randomCreatedAt->copy()->addDays(rand(1, 30)) : null,
                'is_archived' => $i % 3 == 0,
                'archived_at' => $i % 3 == 0 ? $randomCreatedAt->copy()->addMonths(rand(1, 6)) : null,
                'user_id' => 1, // Change if needed
                'created_at' => $randomCreatedAt,
                'updated_at' => $randomCreatedAt->copy()->addDays(rand(1, 20)),
            ];
        }

        DB::table('files')->insert($files);

    }
}
