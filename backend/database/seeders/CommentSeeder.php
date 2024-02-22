<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use App\Models\Comment;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get all user IDs
        $userIds = User::pluck('id')->toArray();

        // Create 10 comments
        for ($i = 0; $i < 10; $i++) {
            $commentIds = Comment::pluck('id')->toArray();
            Comment::create([
                'content' => $faker->paragraph,
                'parent_comment_id' => $faker->randomElement($commentIds),
                'user_id' => $faker->randomElement($userIds),
            ]);
        }
    }
}
