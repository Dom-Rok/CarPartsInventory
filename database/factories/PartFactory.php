<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Car;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\part>
 */
class PartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'name' => $this->faker->randomElement([
                'Brake Pad',
                'Oil Filter',
                'Air Filter',
                'Spark Plug',
                'Clutch',
                'Alternator',
                'Headlight',
                'Tail Light',
                'Battery',
                'Radiator'
            ]),
            'serialnumber' => $this->faker->unique()->numerify('##########'),
            
   
            'car_id' => Car::inRandomOrder()->first()->id,
        ];
    
    }
}
