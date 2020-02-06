<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {

    public static function getOption($key) {
       $option =  Option::where("key",$key)->first();
       return $option->value;
    }

}
