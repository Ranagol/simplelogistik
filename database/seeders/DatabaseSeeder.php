<?php

namespace Database\Seeders;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * jedan@gmail.com is my test user. If there is no user with that email, create it.
         * And, I also need 9 more users.
         */
        $jedan = User::where('name', '=', 'jedan@gmail.com')->get();
        if(!$jedan){
            User::factory()->create([
                'name' => 'jedan@gmail.com',
                'email' => 'jedan@gmail.com',
            ]);
        }
        User::factory(9)->create();
    }
}
