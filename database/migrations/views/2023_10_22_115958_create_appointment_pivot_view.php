<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        DB::statement($this->createOrReplaceView());
    }

    public function down(): void
    {

    }

    private function createOrReplaceView(): string
    {
        return <<<SQL
            CREATE OR REPLACE VIEW appointment_pivot_view as
               select
                   appointments.*,
                   patient.name as 'patient_name',
                   patient.phone as 'patient_phone',
                   doctor.name as 'doctor_name'
            from appointments
                inner join users as patient on appointments.patient_id = patient.id
                inner join users as doctor on appointments.doctor_id = doctor.id
        SQL;
    }
};
