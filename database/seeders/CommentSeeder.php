<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(\App\Models\Comment::class, 5)->create(); // < Laravel Verssion 8
        \App\Models\Comment::factory()->count(15)->create();
    }
}
