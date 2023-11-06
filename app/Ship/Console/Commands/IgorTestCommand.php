<?php

namespace App\Ship\Console\Commands;

use App\Containers\Appointment\Actions\OneCRegistryAppointmentAction;
use App\Containers\Appointment\Models\Appointment;
use Illuminate\Console\Command;

class IgorTestCommand extends Command
{
    protected $signature = 'igor:test';

    protected $description = 'Command description';

    public function handle(): void
    {
        $appointment = Appointment::first();
        dispatch(new OneCRegistryAppointmentAction($appointment))->afterCommit();
    }
}
