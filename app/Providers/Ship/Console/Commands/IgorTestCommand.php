<?php

namespace App\Providers\Ship\Console\Commands;

use App\Containers\User\Models\User;
use Illuminate\Console\Command;

class IgorTestCommand extends Command
{
    protected $signature = 'igor:test';

    protected $description = 'Command description';

    public function handle(): void
    {
        $user = User::query()
            ->filter([
                'search(keyword:Вася, includeId:1)',
            ])
            ->get();
    }
}
