<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Signature('test:email')]
#[Description('Test email configuration by sending a test email')]
class TestEmail extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sending test email...');

        try {
            Mail::raw('This is a test email from NCTU Admissions System.', function ($message) {
                $message->to('test@example.com')
                    ->subject('Test Email - NCTU Admissions');
            });

            $this->info('✅ Email sent successfully to Mailtrap!');
            $this->info('Check your Mailtrap inbox at: https://mailtrap.io/inboxes');
        } catch (\Exception $e) {
            $this->error('❌ Failed to send email: '.$e->getMessage());

            return 1;
        }

        return 0;
    }
}
