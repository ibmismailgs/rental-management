<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $tenant, $due;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tenant, $due)
    {
        $this->tenant = $tenant;
        $this->due = $due;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Flat Rent')
        ->view('rent_info.rent_collect.email');
    }
}
