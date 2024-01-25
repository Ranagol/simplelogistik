<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createUsers();
        $this->createTestUser();
    }

    /**
     * This will create 20 users. This is a collection of users. So we can use the each() method 
     * to assign a dispatcher role to each user.
     */
    private function createUsers()
    {
        
        User::factory(config('constants.numberOfDbRecords'))
            ->create()
            ->each(function ($user) {
                $user->assignRole('dispatcher');
            }
        );
    }

    /**
     * We need a test user for logging in to the application.
     * The test user credentials are stored in the .env file.
     * If there is no user with this given email, create it.
     * Add the admin role to the test user.
     */
    private function createTestUser()
    {
        $testUsername = config('app.testUsername');
        $testPassword = config('app.testPassword');
        $testUser = User::where('name', '=', $testUsername)->get();
        
        if($testUser->isEmpty()){
            $testUser = User::factory()->create([
                'name' => $testUsername,
                'email' => $testUsername,
                'email_verified_at' => now(),
                'password' => Hash::make($testPassword),
                'remember_token' => Str::random(10),
            ]);
        }

        // Assign role to the test user
        $testUser->assignRole('admin');
    }
}
