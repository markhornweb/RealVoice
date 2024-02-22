<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use App\Models\Like;
use App\Models\User;
use App\Models\Post;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $userIds = User::pluck('id')->toArray();
        $postIds = Post::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            Like::create([
                'user_id' => $faker->randomElement($userIds),
                'post_id' => $faker->randomElement($postIds),
            ]);
        }
    }
}
