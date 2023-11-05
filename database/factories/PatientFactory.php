<?php

namespace Database\Factories;

use App\Containers\Patient\Models\Patient;
use App\Containers\User\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        //'+38098' . random_int(1000000, 9999999),
        return [
            'name'       => $this->faker->name(),
            'phone'      => '+38098' . $this->faker->numberBetween(1000000, 9999999),
            'email'      => $this->faker->unique()->safeEmail(),
            'gender'     => fake()->randomElement([GenderEnum::MALE, GenderEnum::FEMALE]),
            'source_id'  => $this->faker->word(),
            'user_id'    => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
