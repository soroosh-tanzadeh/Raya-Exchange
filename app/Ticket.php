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
        $message->from = -1;
        return $message->save();
    }

    public function addMessage($text, $files) {
        $message = new Message();
        $message->files = json_encode($files);
        $message->text = $text;
        $message->ticket_id = $this->id;
        $message->from = session()->get("user")->id;
        return $message->save();
    }

}
