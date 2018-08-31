<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use \App\Http\Resources\NotificationResource;
use \App\Notification;

class NotificationController extends Controller
{

    /**
     * Return Auth User Notifications
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function fetchNotifications(Request $request){
        $user = \Auth::user();
        $notifications = [];
        $left_to_load = 0;
        $_notifications = $user->notifications()->limit(3)->get();
        foreach($_notifications as $notification){
            array_push($notifications, new NotificationResource($notification));
        }

        if(count($_notifications) > 1){
            $left_to_load = $user->notifications()->where('notifications.created_at', '<', $_notifications->last()->created_at)->count();
        }

        return ['notifications' => $notifications, 'left_to_load' => $left_to_load];
    }

    /**
     * Return Auth User more Notifications
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function fetchMoreNotifications(Request $request){
        $user = \Auth::user();
        $notifications = [];
        $left_to_load = 0;
        $_notifications = $user->notifications()->where('notifications.created_at', '<', $request->date)->limit(3)->get();

        foreach($_notifications as $notification){
            array_push($notifications, new NotificationResource($notification));
        }

        if(count($_notifications) > 1){
            $left_to_load = $user->notifications()->where('notifications.created_at', '<', $_notifications->last()->created_at)->count();
        }

        return ['notifications' => $notifications, 'left_to_load' => $left_to_load];
    }

    /**
     * Return One Notification by id
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function fetchNotification(Request $request){
        return ['notification'=> new NotificationResource(Notification::find($request->notification_id))];
    }

    /**
     * Return Auth User Notification Count
     * 
     * @param \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\JsonResource
     */
    public function fetchUnreadNotificationCount(Request $request){
        $user = \Auth::user();
        return $user->unreadNotifications()->count();
    }

    /**
     * Mark All Notifications As Read
     * 
     * @param \Illuminate\Http\Request $request
     * @return String
     */
    public function marReadAll(Request $request){
        $user = \Auth::user();
        $user->unreadNotifications->markAsRead();

        return 'success';
    }
    
}
