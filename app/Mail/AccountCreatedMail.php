<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $defaultPassword;

    public function __construct($user, $defaultPassword = '123456')
    {
        $this->user = $user;
        $this->defaultPassword = $defaultPassword;
    }

    public function build()
    {
        return $this->subject('Your Account Has Been Created - Building Management System')
                    ->view('emails.account-created');
    }
}