<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(\App\Models\Post::class, 5)->create(); // < Laravel Verssion 8
        \App\Models\Post::factory()->count(10)->create();
    }
}
