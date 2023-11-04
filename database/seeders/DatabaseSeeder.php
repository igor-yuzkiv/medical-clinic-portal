<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Containers\Appointment\Models\Appointment;
use App\Containers\Doctor\Models\DoctorPatient;
use App\Containers\Patient\Models\Patient;
use App\Containers\User\Models\User;
use Database\Factories\PatientFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create()->each(fn($doctor) => $this->createForDoctor($doctor));

        $this->createForDoctor(User::find(1));
    }

    private function createForDoctor(User $doctor): void
    {
        $patients = Patient::factory(10)->create();
        foreach ($patients as $patient) {
            DoctorPatient::create([
                'doctor_id'  => $doctor->id,
                'patient_id' => $patient->id,
            ]);

            Appointment::factory(10)->create([
                'doctor_id'  => $doctor->id,
                'patient_id' => $patient->id,
            ]);
        }
    }
}
