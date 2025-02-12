<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class RecordAssignMail extends Mailable
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Record is Assigned to you!')
                    ->view('mail.record_assigned')
                    ->with([
                        'user' => $this->user,
                    ]);
    }
}
