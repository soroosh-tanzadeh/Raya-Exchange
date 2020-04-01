<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    public function getTicketTypes() {
        $permission = Permission::where("id", $this->permissions)->first();
        $permissions = json_decode($permission->permissions);
        return $permissions->tickets;
    }

}
