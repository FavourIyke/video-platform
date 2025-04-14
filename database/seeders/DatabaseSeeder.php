<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call the CategorySeeder and VideoSeeder
        $this->call([
            CategorySeeder::class,
            VideoSeeder::class,
        ]);
    }
}
