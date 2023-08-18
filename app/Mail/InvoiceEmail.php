<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $getUser;

    /**
     * Create a new message instance.
     *
     * @param  \App\TransactionHeader  $transaction
     * @return void
     */
    public function __construct($transaction,$getUser)
    {
        $this->transaction = $transaction;
        $this->getUser = $getUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.invoice')
            ->subject('Invoice for Transaction ' . $this->transaction->no_transaction);
    }
}
