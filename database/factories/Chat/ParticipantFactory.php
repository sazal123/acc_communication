<?php

namespace Database\Factories\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat\Participant
 */
class ParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uid' => $this->faker->uuid,
            'udid' => $this->faker->uuid,
            'company_id' => 1,
            'is_group' => false,
            'is_active' => true,
        ];
    }
}
