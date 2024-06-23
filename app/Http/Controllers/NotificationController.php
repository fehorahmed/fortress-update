<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function all() {
        return view('notification.all');
    }

    public function markRead() {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function notificationRead($id) {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['link']);
        }
    }
}
