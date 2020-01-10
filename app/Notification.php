<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

    public static function sendNotification($title, $text, $user_id, $target = "#") {
        
    }

    public function getTarget() {
        $target = $this->target;
        return url("/readNotif?id=$this->id&target=$target");
    }

    public static function read($id) {
        $notif = Notification::where("id", $id)->first();
        $notif->read = true;
        $notif->save();
    }

    public static function getNotifications() {
        return Notification::where("user_id", session()->get("user")->id)->where("read", false)->get();
    }

}
