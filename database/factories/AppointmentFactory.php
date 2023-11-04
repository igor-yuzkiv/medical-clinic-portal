<?php

namespace Database\Factories;

use App\Containers\Appointment\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'date_time'    => Carbon::now(),
            'service_name' => $this->faker->randomElement(["kt", "mrt", "x_ray"]),
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ];
    }
}
