<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Message;

class Ticket extends Model {

    public function getMessages() {
        $messages = Message::where("ticket_id", $this->id)->get();
        return $messages;
    }

    public function addAdminMessage($text, $files) {
        $message = new Message();
        $message->files = json_encode($files);
        $message->text = $text;
        $message->ticket_id = $this->id;
        $message->from = session()->get("user_admin")->id;
        $message->is_admin = true;
        Notification::sendNotification("پیام جدید", "تیکت شماره $this->id را چک کنید", $this->user_id, "/dashboard/ticket/$this->id");
        return $message->save();
    }

    public function addMessage($text, $files) {
        $message = new Message();
        $message->files = json_encode($files);
        $message->text = $text;
        $message->ticket_id = $this->id;
        $message->from = session()->get("user")->id;
        $message->is_admin = false;
        return $message->save();
    }

}
