<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function userNotification(){
        $userId = Auth::id();
        $sentMails = Notification::where('from_id', $userId)->get();
        $receivedMails = Notification::where('to_id', $userId)->get();

        $combinedMails = $sentMails->map(function ($mail) {
            $mail->type = 'Sent';
            $mail->person = \App\Models\User::where('id', $mail->to_id)->value('name'); // Get recipient's name
            return $mail;
        })->merge(
            $receivedMails->map(function ($mail) {
                $mail->type = 'Received';
                $mail->person = \App\Models\User::where('id', $mail->from_id)->value('name'); // Get sender's name
                return $mail;
            })
        );

        return view('frontend.notification.notification-list', compact('combinedMails'));
    }

    public function notificationSeen($id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->update(['notification_status' => 1]);
        }
        return redirect()->route('notification.details', ['id' => $id]);
    }

    public function show($id, Request $request){
        $data = Notification::find($id);
        return view('frontend.notification.notification-detail', compact('data'));
    }
}
