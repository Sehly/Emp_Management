<?php

namespace Database\Factories;
use App\Models\Department;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'hire_date' => $this->faker->date,
            'salary' => $this->faker->numberBetween(10000, 25000),
            'department_id' => Department::factory(), 
        ];
        
    }
}