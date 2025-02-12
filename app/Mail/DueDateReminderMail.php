<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DueDateReminderMail extends Mailable
{
    use SerializesModels;

    public $record;
    public $daysRemaining;
    public $processName;

    public function __construct($record, $daysRemaining, $processName)
    {
        $this->record = $record;
        $this->daysRemaining = $daysRemaining;
        $this->processName = $processName;
    }

    public function build()
    {
        return $this->subject("Reminder: {$this->processName} Due Date Approaching")
            ->view('mail.due_date_reminder')
            ->with([
                'record' => $this->record,
                'daysRemaining' => $this->daysRemaining,
                'processName' => $this->processName,
            ]);
    }
}
