<?php

namespace App\Console;

use App\Models\CC;
use App\Models\Deviation;
use App\Mail\DueDateReminderMail;
use App\Mail\OverdueReminderMail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{

    /******** Function for Sending Due Date Mail *********/
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $this->sendReminderEmails(
                CC::where('status', '!=', 'Closed Done')
                    ->whereDate('due_date', '>=', now())
                    ->whereDate('due_date', '<=', now()->addDays(7))
                    ->get(),
                'Change Control'
            );
        })->dailyAt('12:40');

        $schedule->call(function () {
            $this->sendReminderEmails(
                Deviation::where('status', '!=', 'Closed Done')
                    ->whereDate('due_date', '>=', now())
                    ->whereDate('due_date', '<=', now()->addDays(7))
                    ->get(),
                'Deviation'
            );
        })->dailyAt('12:40');

        /*********** Send Overdue Mail ***********/
        $schedule->call(function () {
            $this->sendOverdueEmails(
                CC::where('status', '!=', 'Closed Done')
                    ->whereDate('due_date', '<', now())
                    ->get(),
                'Change Control'
            );
        })->dailyAt('12:40');

        $schedule->call(function () {
            $this->sendOverdueEmails(
                Deviation::where('status', '!=', 'Closed Done')
                    ->whereDate('due_date', '<', now())
                    ->get(),
                'Deviation'
            );
        })->dailyAt('12:40');

        $schedule->command('schedule:run')->everyMinute();
    }

    protected function sendReminderEmails($records, $processName)
    {
        foreach ($records as $record) {
            $dueDate = Carbon::parse($record->due_date);
            $daysRemaining = $dueDate->diffInDays(now());
            $userEmail = $record->initiator;

            try {
                if ($daysRemaining == 0) {
                    Mail::to($userEmail)->send(new DueDateReminderMail($record, 'Due today', $processName));
                } else {
                    Mail::to($userEmail)->send(new DueDateReminderMail($record, $daysRemaining, $processName));
                }
            } catch (\Exception $e) {
                Log::error("Failed to send email for {$processName} record ID: {$record->id}. Error: " . $e->getMessage());
            }
        }
    }

    protected function sendOverdueEmails($records, $processName)
    {
        foreach ($records as $record) {
            $dueDate = Carbon::parse($record->due_date);
            $daysOverdue = $dueDate->diffInDays(now());

            $userEmail = $record->initiator;

            try {
                if ($daysOverdue > 0) {
                    Mail::to($userEmail)->send(new OverdueReminderMail($record, $daysOverdue, $processName));
                }
            } catch (\Exception $e) {
                Log::error("Failed to send overdue email for {$processName} record ID: {$record->id}. Error: " . $e->getMessage());
            }
        }
    }


    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
