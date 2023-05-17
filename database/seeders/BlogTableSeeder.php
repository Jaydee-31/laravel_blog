<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\User;
use Faker\Factory as FakerFactory;


class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::all();
        $faker = FakerFactory::create();

        for ($i = 0; $i < 6; $i++) {
            $blog = new Blog();
            $blog->image = $faker->image('public/storage/blog-photos',400,300, null, false) ;
            $blog->title = $faker->sentence();
            $blog->content = $faker->words(500, true);
            $blog->author_id = $users->random()->id;
            $blog->save();
        }
    }
    
}
