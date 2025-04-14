<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'name' => 'Technology',
            'slug' => 'technology',
            'description' => 'Latest trends and news in technology.'
        ]);

        Category::create([
            'name' => 'Health',
            'slug' => 'health',
            'description' => 'All about health, wellness, and fitness.'
        ]);

        Category::create([
            'name' => 'Entertainment',
            'slug' => 'entertainment',
            'description' => 'Movies, shows, and fun content.'
        ]);
    }
}
