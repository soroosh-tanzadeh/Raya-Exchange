<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TCategories extends Model
{
        protected $table = "tutorial_categories";

    public function getQuestions() {
        $questions = Tutorials::where("category", $this->id)->get();
        return $questions;
    }
}
