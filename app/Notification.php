<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

    public static function sendNotification($title, $text, $user_id, $target = "#") {
        $notif = new Notification();
        $notif->title = $title;
        $notif->read = false;
        $notif->text = $text;
        $notif->target = $target;
        $notif->user_id = $user_id;
        return $notif->save();
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

    public static function getAdminNotifications() {
        return Notification::where("user_id", -1)->where("read", false)->get();
    }

}
