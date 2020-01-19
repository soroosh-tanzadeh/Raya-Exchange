<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model {

    public static function getWallets() {
        $user = session()->get("user");
        $coinWallets_data = Wallet::where("user_id", $user->id)->where("type", "coin")->get();
        $coinWallets = array();
        foreach ($coinWallets_data as $wallet) {
            $coinWallets[$wallet->type_name] = $wallet;
        }
        return $coinWallets;
    }

}
