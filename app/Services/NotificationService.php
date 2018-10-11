<?php

namespace App\Services;

use \App\User;
use \App\Opening;
use \App\Http\Resources\UserResource;
use \App\Http\Resources\NotificationResource;

class NotificationService
{
    protected $auth;

    function __construct(){
        $this->auth = \Auth::user();
    }

    function fetchNotification(){
        $notifications = [];
        $left_to_load = 0;
        $_notifications = $this->auth->notifications()->limit(3)->get();
        foreach($_notifications as $notification){
            array_push($notifications, new NotificationResource($notification));
        }

        if(count($_notifications) > 1){
            $left_to_load = $this->auth->notifications()->where('notifications.created_at', '<', $_notifications->last()->created_at)->count();
        }

        return ['notifications' => $notifications, 'left_to_load' => $left_to_load];
    }
}
