<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

    public static function getActivities() {
        if (session()->has("user")) {
            return Activity::where("user_id", session()->get("user")->id)->latest()->limit(7)->get();
        } else {
            return array();
        }
    }

    public static function addActivity($text) {
        if (session()->has("user")) {
            $activity = new Activity();
            $activity->user_id = session()->get("user")->id;
            $activity->text = $text;
            $activity->save();
        }
    }

}
