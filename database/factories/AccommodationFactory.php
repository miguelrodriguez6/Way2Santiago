<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Accommodation>
 */
class AccommodationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'        => $this->faker->company . ' Hotel',
            'description' => $this->faker->paragraph(),
            'address'     => $this->faker->streetAddress(),
            'city'        => $this->faker->city(),
            'country'     => $this->faker->country(),
            'link'        => $this->faker->url(),
        ];
    }
}
