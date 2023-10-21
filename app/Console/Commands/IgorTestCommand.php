<?php

namespace App\Console\Commands;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Console\Command;

class IgorTestCommand extends Command
{
    protected $signature = 'igor:test';

    protected $description = 'Command description';

    public function handle(): void
    {
        $user = User::query();
    }
}
