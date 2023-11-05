<?php

namespace Database\Factories;

use App\Containers\Appointment\Enums\ServiceType;
use App\Containers\Appointment\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $serviceTypes = array_map(fn($type) => $type->value, ServiceType::cases());
        return [
            'date_time'    => Carbon::now(),
            'service_type' => $this->faker->randomElement($serviceTypes),
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ];
    }
}
