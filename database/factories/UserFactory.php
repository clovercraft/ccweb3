<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
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
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'discord_id' => fake()->unique()->uuid(),
            'minecraft_id' => fake()->unique()->uuid(),
            'role_id' => Role::factory()->member()->create(),
            'status' => 'new'
        ];
    }

    public function whitelisted()
    {
        return $this->state(fn (array $attributes) => [
            'whitelisted_at' => now(),
            'status' => 'active'
        ]);
    }

    public function inactive()
    {
        return $this->state(fn (array $attributes) => [
            'whitelisted_at' => now(),
            'status' => 'inactive'
        ]);
    }

    public function banned()
    {
        return $this->state(fn (array $attributes) => [
            'whitelisted_at' => now()->subMonths(2),
            'banned_at' => now(),
            'status' => 'banned'
        ]);
    }
}
