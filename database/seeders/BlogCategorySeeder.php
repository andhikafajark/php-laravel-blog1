<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        BlogCategory::insert([
            [
                'id' => 'e976eba4-6853-4405-9549-a503ab645981',
                'title' => 'PHP',
                'slug' => str()->slug('PHP'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
