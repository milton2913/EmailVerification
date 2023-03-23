<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EmailVerifier;

class VerifyEmailsCommand extends Command
{
    protected $signature = 'emails:verify {emails}';

    protected $description = 'Verify a list of emails';

    public function handle()
    {
        $emails = explode(',', $this->argument('emails'));

        $verifier = new EmailVerifier();
        foreach ($emails as $email) {
            if ($verifier->verify($email)) {
                $this->info("$email is valid.");
            } else {
                $this->warn("$email is invalid.");
            }
        }
    }
}
