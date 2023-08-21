<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Endroid\QrCode\QrCode;

class ETicketEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $transactionHeader;
    public $transactionDetail;
    public $getEventInfo;
    public $qrCode;

    /**
     * Create a new message instance.
     *
     * @param $user User object
     * @param $transactionHeader Event object
     * @param $transactionDetail Array containing ticket details
     */
    public function __construct($user, $transactionHeader, $transactionDetail, $getEventInfo, $qrCode)
    {
        $this->user = $user;
        $this->transactionHeader = $transactionHeader;
        $this->transactionDetail = $transactionDetail;
        $this->getEventInfo = $getEventInfo;
        $this->qrCode = $qrCode; // Add this line
    }
    

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your E-Ticket for ' . $this->getEventInfo->event_name)
            ->view('mail.eticket');
    }
}
