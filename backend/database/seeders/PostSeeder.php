<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $categoryIds = Category::pluck('id')->toArray();

        $userIds = User::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            Post::create([
                'title' => $faker->sentence,
                'thumbnail' => $faker->imageUrl(),
                'commenting_status' => $faker->boolean,
                'bgm' => $faker->word,
                'voice' => $faker->imageUrl(),
                'video' => $faker->url() . '.mp4',
                'voice_text' => $faker->paragraph,
                'category_id' => $faker->randomElement($categoryIds),
                'user_id' => $faker->randomElement($userIds),
            ]);
        }
    }
}
