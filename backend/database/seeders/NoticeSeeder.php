<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use App\Models\Notice;
use App\Models\User;
use App\Models\Comment;

use Str;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $userIds = User::pluck('id')->toArray();
        $commentIds = Comment::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            Notice::create([
                'type' => $faker->randomElement([1, 2, 3]),
                'reading_status' => $faker->boolean,
                'title' => Str::random(10),
                'content' => $faker->sentence,
                'sent_user_id' => $faker->randomElement($userIds),
                'receive_user_id' => $faker->randomElement($userIds),
                'comment_id' => $faker->randomElement($commentIds),
            ]);
        }
    }
}
