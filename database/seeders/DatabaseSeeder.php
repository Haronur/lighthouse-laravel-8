<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(5)->create();
        $this->call(PostSeeder::class);         // OR \App\Models\Post::factory()->count(10)->create();
        $this->call(CommentSeeder::class);      // OR \App\Models\Comment::factory()->count(15)->create();
    }
}
