<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\User;
use App\Notifications\BaseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends BaseController
{
    public function sendNotification(Request $request) {
       try {
           $validated = $request->validate([
               'users' => 'array|nullable', // List of user IDs
               'condition' => 'array|nullable', // Conditions like ['role' => 'admin']
               'subject' => 'required|string',
               'body' => 'required|string',
               'channels' => 'array|nullable', // Optional: ['mail', 'sms', 'database']
           ]);

           $message = [
               'subject' => $validated['subject'],
               'body' => $validated['body'],
           ];

           $users = collect();

           // Send to a list of users
           if (isset($validated['users'])) {
               $users = $users->merge(User::whereIn('id', $validated['users'])->get());
           }

           if (!isset($validated['users']) && !isset($validated['condition'])) {
               $users = $users->merge(User::all());
           }

           // Send based on condition
//        if (isset($validated['condition'])) {
//            $users = $users->merge(User::where($validated['condition'])->get());
//        }

           // If no users or conditions are provided, send to all users
           if ($users->isEmpty()) {
               $users = User::all();
           }

           // Send notifications
           Notification::send($users->unique(), new BaseNotification($message));

           return $this->sendResponse(['message' => count($users) . ' Notifications sent successfully'], 200);
       } catch(\Exception $ex) {
           return $this->sendError($ex, ["Error sending notifications", $ex->getMessage()], 500);
       }
    }

    // TODO:
    //  get notification by user
    //  get notification by sender
    //  get notification by filter
    //  mark notification as read
    //  mark as unread
    //  mark all as read
    //  archive/delete notifications
}
