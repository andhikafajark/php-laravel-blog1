<?php

namespace Database\Seeders;

use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Blog::insert([
            [
                'id' => 'e976eba4-6853-4405-9549-a503ab645981',
                'user_id' => 'e976eba4-6853-4405-9549-a503ab645981',
                'blog_category_id' => 'e976eba4-6853-4405-9549-a503ab645981',
                'title' => 'Blog PHP',
                'slug' => str()->slug('Blog PHP'),
                'content' => 'Blog PHP',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
