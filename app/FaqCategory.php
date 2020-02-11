<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model {

    protected $table = "faq_categories";

    public function getQuestions() {
        $questions = Question::where("category", $this->id)->get();
        return $questions;
    }

}
