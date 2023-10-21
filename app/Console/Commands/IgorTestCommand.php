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
            'name'     => 'Ігор Юзьків',
            'login'    => '380999999999',
            'email'    => null,
            'phone'    => '380999999999',
            'password' => \Hash::make('12345')
        ]);
    }
}
