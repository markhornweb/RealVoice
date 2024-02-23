<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;
use Str;
use Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('ja_JP');

        DB::table('users')->insert([
            'name' => "桜井 美咲",
            'nick_name' => "rocky",
            'email' => "seniordev731@gmail.com",
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'avatar' => $faker->imageUrl(),
            'gender' => "男性",
            'birthday' => $faker->date,
            'description' => $faker->sentence,
            'phone_number' => "+811234567890",
            'is_active' => 0,
            'last_logined_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
            'remember_verify_code' => "1234",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        for ($i = 0; $i < 9; $i ++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'nick_name' => Str::random(5),
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'avatar' => $faker->imageUrl(),
                'gender' => $faker->randomElement(['男性', '女性']),
                'birthday' => $faker->date,
                'description' => $faker->sentence,
                'phone_number' => "+811234567890",
                'is_active' => 0,
                'last_logined_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                'remember_verify_code' => "1234",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
