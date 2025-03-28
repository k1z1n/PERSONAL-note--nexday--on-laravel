<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected User $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Подтверждение email')
            ->view('emails.verify-email')
            ->with([
                'verificationUrl' => URL::temporarySignedRoute(
                    'verification.verify',
                    now()->addMinutes(2),
                    ['id' => $this->user->getKey()]
                ),
            ]);
    }
}

//'verificationUrl' => URL::temporarySignedRoute(
//    'verification.verify',
//    now()->addMinutes(2),
//    [
//        'id' => $this->user->id,
//        'hash' => sha1($this->user->email),
//    ]
//),
