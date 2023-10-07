<?php

namespace Database\Factories\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat\Chat
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uid' => $this->faker->sentence,
            'udid' => $this->faker->sentence,
            'company_id' => 1,
            'is_group' => true,
            'is_active' => true,
        ];
    }
}
