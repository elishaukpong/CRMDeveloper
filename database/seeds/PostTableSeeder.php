<?php

use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::role('Writer')->exists()){
            factory(Post::class,4)->create();
        }
    }
}
