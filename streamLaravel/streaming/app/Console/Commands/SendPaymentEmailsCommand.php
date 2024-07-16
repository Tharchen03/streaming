<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendPaymentEmails;

class SendPaymentEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send payment emails to all users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        SendPaymentEmails::dispatch();
        $this->info('Payment emails dispatched successfully.');
        
        return 0;
    }
}
