<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isRegistered = $this->faker->boolean();
        return [
            'name' => $this->faker->unique()->randomElement([
                'Toyota Corolla',
                'BMW 320d',
                'Audi A4',
                'Škoda Octavia',
                'Mercedes C200',
                'Ford Focus',
                'Volkswagen Golf',
                'Mercedes Benz',
                'Honda Civic',
                'Hyundai Elantra',
                'Kia Ceed',
                'Nissan Altima',
                'Peugeot 308',
                'Renault Megane',
                'Opel Astra',
                'Seat Leon',
                'Volkswagen Passat',
                'Toyota Camry',
                'Audi Q5',
                'BMW X3',
                'Mazda 3',
                'Ford Fiesta',
                'Mini Cooper',
                'Volvo S60',
                'Lexus RX',
                'Mitsubishi Lancer',
                'Citroën C4',
                'Jaguar XE',
                'Mercedes E-Class',
                'Audi A6',
                'Hyundai Tucson'

            ]),
            'registration_number' => $isRegistered
                ? strtoupper($this->faker->unique()->bothify('??###??'))
                : null,
            'is_registered' => $isRegistered,
        ];
    }
}
