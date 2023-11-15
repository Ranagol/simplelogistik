<?php

namespace Database\Factories;

use App\Models\TmsDispatcher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tms_dispatcher>
 */
class TmsDispatcherFactory extends Factory
{
    protected $model = TmsDispatcher::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // password
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
