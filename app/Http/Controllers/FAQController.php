<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FaqCategory;
use App\Question;

class FAQController extends Controller {

    public function deleteQ(Request $request) {
        $question = Question::findOrFail($request->id);
        return response()->json(array("result" => $question->delete()));
    }

    public function deleteC(Request $request) {
        $category = FaqCategory::findOrFail($request->id);
        return response()->json(array("result" => $category->delete()));
    }

    public function newC(Request $request) {
        $category = new FaqCategory();
        $category->name = $request->name;
        $category->icon = $request->icon;
        return response()->json(array("result"=>$category->save(),"msg"=>"با موفقیت ایجاد شد."));
    }

}
