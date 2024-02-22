<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i ++) {
            DB::table('categories')->insert([
                'title' => "カテゴリー" . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
