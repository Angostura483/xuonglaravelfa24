<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Manager;
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
            'first_name'        => fake()->firstName,
            'last_name'         => fake()->lastName,
            'email'             => fake()->unique()->email,
            'phone'             => fake()->phoneNumber,
            'date_of_birth'     => fake()->date,
            'hire_date'         => fake()->dateTimeThisYear,
            'salary'            => fake()->numberBetween(5000000, 60000000),
            'is_active'         => rand(0, 1),
            'department_id'     => Department::pluck('id')->random(),
            'manager_id'        => Manager::pluck('id')->random(),
            'address'           => fake()->address,
            'profile_picture'   => fake()->postcode,
        ];
    }
}
