<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function getCategory(){
        $category = Category::find($this->category);
        return $category->name;
    }
}
