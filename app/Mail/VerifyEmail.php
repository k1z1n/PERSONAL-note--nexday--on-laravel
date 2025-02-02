<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Подтверждение email')
            ->view('emails.verify-email')
            ->with([
                'verificationUrl' => URL::temporarySignedRoute(
                    'verification.verify',
                    now()->addMinutes(2),
                    [
                        'id' => $this->user->id,
                        'hash' => sha1($this->user->email),
                    ]
                ),
            ]);
    }
}
