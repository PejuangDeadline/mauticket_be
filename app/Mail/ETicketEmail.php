<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ETicketEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $event;
    public $ticketDetails;
    public $getEventInfo;

    /**
     * Create a new message instance.
     *
     * @param $user User object
     * @param $event Event object
     * @param $ticketDetails Array containing ticket details
     */
    public function __construct($user, $event, $ticketDetails,$getEventInfo)
    {
        $this->user = $user;
        $this->event = $event;
        $this->ticketDetails = $ticketDetails;
        $this->getEventInfo = $getEventInfo;
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
