<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubmitContactUs extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The request instance
     * 
     * @var $request
     */
    public $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Jobseed User Contact Us Submitted');

        return $this->view('emails.contact-us');
    }
}
