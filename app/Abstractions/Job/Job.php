<?php

namespace App\Abstractions\Job;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 *
 */
abstract class Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    protected int $tries = 1;

    /**
     * @var int
     * retry after seconds
     */
    protected int $retryAfter = 10;

    /**
     * @return mixed|void
     */
    abstract public function handle();

    /**
     * @param \Throwable $exception
     * @return void
     */
    public function failed(\Throwable $exception): void
    {
        $this->attempt();
    }

    /**
     * @return void
     */
    protected function attempt(): void
    {
        if ($this->attempts() < $this->tries) {
            logger()->error("[Job::attempts] [" . static::class . "]", ["tries" => $this->tries]);
            $this->release($this->retryAfter);
        }
    }
}
