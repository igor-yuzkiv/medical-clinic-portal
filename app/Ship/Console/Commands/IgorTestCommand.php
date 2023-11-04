<?php

namespace App\Ship\Console\Commands;

use App\Containers\Patient\Models\Patient;
use Illuminate\Console\Command;

class IgorTestCommand extends Command
{
    protected $signature = 'igor:test';

    protected $description = 'Command description';

    public function handle(): void
    {
        $id = 1;

        $p = Patient::filter([
            'doctor(1)'
        ])->get()->toArray();

        dd($p);
    }
}
