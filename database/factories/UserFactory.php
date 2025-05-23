<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Default password
            'role' => 'user', // Default role
            'remember_token' => Str::random(10),
            // 'referred_by' => 3,
        ];
    }

    /**
     * Define an admin state.
     */
    public function admin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
            ];
        });
    }

    /**
     * Define a user state.
     */
    public function user(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('user12345'),
                'role' => 'user',
            ];
        });
    }

    /**
     * Define an affiliate state.
     */
    public function affiliate(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'affiliate',
                'email' => 'affiliate@gmail.com',
                'password' => Hash::make('affiliate12345'),
                'role' => 'affiliate',
                'referral_code' => Str::random(10),
            ];
        });
    }
}
