<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function getPosts(){
        $posts = Post::where("category", $this->id)->latest()->get();
        return $posts;
    }
}
