<?php

namespace App\Jobs;

use App\Models\ValidEmail;
use App\Services\EmailVerifier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VerifyValidEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $validEmail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($validEmail)
    {
        $this->validEmail = $validEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $verifyEmail = new EmailVerifier();
        $verifyEmail->emailVerify($this->validEmail);
    }
}
