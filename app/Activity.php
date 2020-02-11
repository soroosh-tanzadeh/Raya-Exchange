<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

    public static function getActivities() {
        return Activity::where("user_id", session()->get("user")->id)->latest()->limit(7)->get();
    }

    public static function addActivity($text) {
        $activity = new Activity();
        $activity->user_id = session()->get("user")->id;
        $activity->text = $text;
        $activity->save();
    }

}