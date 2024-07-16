<?php

namespace App\Jobs;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPaymentEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payments = Payment::all();
        
        foreach ($payments as $payment) {
            $to = $payment->email_id;
            $detail = [
                'name' => $payment->name,
                'product' => $payment->product,
                'price' => $payment->price,
                // 'random_text' => $payment->random_text,
            ];

            job_mail_helper($to,  'job Successful', $detail);
        }
    }
}
