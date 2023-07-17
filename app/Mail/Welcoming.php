<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Welcoming extends Mailable
{
    use Queueable, SerializesModels;

    public $namauser;

    public function __construct($namauser)
    {
        $this->namauser = $namauser;
    }

    public function build()
    {
        return $this->subject('Selamat Bergabung Dengan MauKarcis')->markdown('mail.welcomingmessage');
    }
}