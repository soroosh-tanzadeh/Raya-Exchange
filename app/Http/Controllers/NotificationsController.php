<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;

class NotificationsController extends Controller
{
    public function read(Request $request){
        $notif = Notification::read($request->id);
        return redirect($request->target);
    }
}
