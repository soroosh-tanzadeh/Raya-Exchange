<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    public function getFiles() {
        $files = (array) json_decode($this->files);
        return $files;
    }

}
