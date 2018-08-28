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

        foreach($user->notifications()->limit(3)->get() as $notification){
            array_push($notifications, new NotificationResource($notification));
        }

        return ['notifications' => $notifications];
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


        foreach($user->notifications()->where('notifications.created_at', '<', $request->date)->limit(3)->get() as $notification){
            array_push($notifications, new NotificationResource($notification));
        }

        return ['notifications' => $notifications];
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
