<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {

    public static function getOption($key) {
        $option = Option::where("key", $key)->first();
        return $option->value;
    }

    public static function isVerified() {
        if (session()->has('user')) {
            $user = session()->get('user');
            $select = User::where("phone_number", $user->phone_number)->where('password', $user->password)->first();
            if ($select !== null) {
                if ($select->verified_at !== null) {
                    session()->put('user', $select);
                } elseif ($select->name !== null) {
                    return "false";
                } else {
                    return "false";
                }
            } else {
                session()->remove("user");
                return false;
            }
        } else {
            return "false";
        }
        return "true";
    }

}
