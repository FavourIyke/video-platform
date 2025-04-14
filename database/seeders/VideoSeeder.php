<?php

namespace Database\Seeders;

use App\Models\Video;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;  // Import Str class for generating slugs

class VideoSeeder extends Seeder
{
    public function run()
    {
        // Fetch categories
        $technology = Category::where('slug', 'technology')->first();
        $health = Category::where('slug', 'health')->first();
        $entertainment = Category::where('slug', 'entertainment')->first();
        
        // Get the first user (you can adjust this based on your logic)
        $user = User::first();

        // Create videos with slugs, video paths, and the provided thumbnail path
        Video::create([
            'title' => 'Tech Innovations 2025',
            'slug' => Str::slug('Tech Innovations 2025'),
            'description' => 'The latest innovations in technology for 2025.',
            'category_id' => $technology->id,
            'user_id' => $user->id,
            'video_path' => 'videos/tech_innovations_2025.mp4',  // Provide video path
            'thumbnail_path' => 'https://www.premiumbeat.com/blog/wp-content/uploads/2018/04/design-thumbnail.jpg',  // Provided thumbnail URL
        ]);

        Video::create([
            'title' => 'The Future of AI in Healthcare',
            'slug' => Str::slug('The Future of AI in Healthcare'),
            'description' => 'How AI is revolutionizing the healthcare industry.',
            'category_id' => $technology->id,
            'user_id' => $user->id,
            'video_path' => 'videos/future_of_ai_healthcare.mp4',  // Provide video path
            'thumbnail_path' => 'https://www.premiumbeat.com/blog/wp-content/uploads/2018/04/design-thumbnail.jpg',  // Provided thumbnail URL
        ]);

        Video::create([
            'title' => 'Smart Gadgets for 2025',
            'slug' => Str::slug('Smart Gadgets for 2025'),
            'description' => 'Explore the coolest tech gadgets coming in 2025.',
            'category_id' => $technology->id,
            'user_id' => $user->id,
            'video_path' => 'videos/smart_gadgets_2025.mp4',  // Provide video path
            'thumbnail_path' => 'https://www.premiumbeat.com/blog/wp-content/uploads/2018/04/design-thumbnail.jpg',  // Provided thumbnail URL
        ]);

        Video::create([
            'title' => 'Healthy Living Tips',
            'slug' => Str::slug('Healthy Living Tips'),
            'description' => 'Tips for living a healthy and active life.',
            'category_id' => $health->id,
            'user_id' => $user->id,
            'video_path' => 'videos/healthy_living_tips.mp4',  // Provide video path
            'thumbnail_path' => 'https://www.premiumbeat.com/blog/wp-content/uploads/2018/04/design-thumbnail.jpg',  // Provided thumbnail URL
        ]);

        Video::create([
            'title' => 'The Benefits of Meditation',
            'slug' => Str::slug('The Benefits of Meditation'),
            'description' => 'How meditation can improve your mental health.',
            'category_id' => $health->id,
            'user_id' => $user->id,
            'video_path' => 'videos/benefits_of_meditation.mp4',  // Provide video path
            'thumbnail_path' => 'https://www.premiumbeat.com/blog/wp-content/uploads/2018/04/design-thumbnail.jpg',  // Provided thumbnail URL
        ]);

        Video::create([
            'title' => 'Top Fitness Exercises for Beginners',
            'slug' => Str::slug('Top Fitness Exercises for Beginners'),
            'description' => 'A guide to starting your fitness journey with simple exercises.',
            'category_id' => $health->id,
            'user_id' => $user->id,
            'video_path' => 'videos/top_fitness_exercises_beginners.mp4',  // Provide video path
            'thumbnail_path' => 'https://www.premiumbeat.com/blog/wp-content/uploads/2018/04/design-thumbnail.jpg',  // Provided thumbnail URL
        ]);

        Video::create([
            'title' => 'Top Movies of 2025',
            'slug' => Str::slug('Top Movies of 2025'),
            'description' => 'The most anticipated movies of 2025.',
            'category_id' => $entertainment->id,
            'user_id' => $user->id,
            'video_path' => 'videos/top_movies_2025.mp4',  // Provide video path
            'thumbnail_path' => 'https://www.premiumbeat.com/blog/wp-content/uploads/2018/04/design-thumbnail.jpg',  // Provided thumbnail URL
        ]);

        Video::create([
            'title' => 'Best TV Shows to Watch This Year',
            'slug' => Str::slug('Best TV Shows to Watch This Year'),
            'description' => 'The top TV shows to keep an eye on in 2025.',
            'category_id' => $entertainment->id,
            'user_id' => $user->id,
            'video_path' => 'videos/best_tv_shows_2025.mp4',  // Provide video path
            'thumbnail_path' => 'https://www.premiumbeat.com/blog/wp-content/uploads/2018/04/design-thumbnail.jpg',  // Provided thumbnail URL
        ]);
    }
}
