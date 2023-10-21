<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class IgorTestCommand extends Command
{
    protected $signature = 'igor:test';

    protected $description = 'Command description';

    public function handle(): void
    {
        $user = User::create([
            'name'     => 'Test Patient',
            'phone'    => '380999999999',
            'is_active' => false,
            'password' => \Hash::make(\Str::random(8)),
            'login' => '380999999999',
        ]);
    }
}
