<?php

namespace App\Mail;

use App\Models\CC;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OverdueReminderMail extends Mailable
{
    use SerializesModels;

    public $record;
    public $daysOverdue;
    public $processName;

    public function __construct($record, $daysOverdue, $processName)
    {
        $this->record = $record;
        $this->daysOverdue = $daysOverdue;
        $this->processName = $processName;
    }

    public function build()
    {
        return $this->subject("Overdue Notification: {$this->processName} Record Overdue")
            ->view('mail.overdue_reminder');
    }
}