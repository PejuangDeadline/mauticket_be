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

    public $getEvenetInfo;

    /**
     * Create a new message instance.
     *
     * @param  \App\TransactionHeader  $transaction
     * @return void
     */
    public function __construct($transaction,$getUser,$getEvenetInfo)
    {
        $this->transaction = $transaction;
        $this->getUser = $getUser;
        $this->getEvenetInfo = $getEvenetInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "[maukarcis.com-Invoice] Order ID " . $this->transaction->no_transaction . " (" . $this->getEvenetInfo->event_name . ")";
    
        return $this->view('mail.invoice')
            ->subject($subject);
    }
    

}
