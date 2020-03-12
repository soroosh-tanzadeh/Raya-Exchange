<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;

class PostsController extends Controller {

    public function index() {
        $categories = Category::all();
        return view("dashboard.knowledge", array("categories" => $categories, "user" => session()->get("user")));
    }

    public function createCategory(Request $request) {
        if ($request->has("name")) {
            $category_name = $request->name;
            $category = new Category();
            $category->name = $category_name;
            $result = $category->save();
            if ($result) {
                return response()->json(array("result" => true, "msg" => "با موفقیت ذخیره شد"));
            } else {
                return response()->json(array("result" => false, "msg" => "خطا در ذخیره اطلاعات مجدد تلاش کنید!"));
            }
        } else {
            return response()->json(array("result" => false, "msg" => "نام دسته‌بندی اجباری است."));
        }
    }

    public function list(Request $request) {
        $posts = Post::latest()->paginate(10);
        return view("admin.posts.posts", array("posts" => $posts, "user" => session()->get("user")));
    }

    public function createPost(Request $request) {
        try {
            $name = $request->name;
            $text = $request->text;
            $category = $request->category;
            $post = new Post();
            $post->name = $name;
            $post->category = $category;
            $post->text = $text;
            $result = $post->save();
            if ($result) {
                return response()->json(array("result" => true, "msg" => "با موفقیت ذخیره شد"));
            } else {
                return response()->json(array("result" => false, "msg" => "خطا در ذخیره اطلاعات مجدد تلاش کنید!"));
            }
        } catch (Exception $ex) {
            return response()->json(array("result" => false, "msg" => "وارد کردن تمامی فیلدها اجباری است."));
        }
    }
    
    
    public function deletePost(Request $request){
        $post = Post::findOrFail($request->id);
        $post->delete();
        return redirect("admin/posts/");
    }

    public function editPost($id, Request $request) {
        try {
            $name = $request->name;
            $text = $request->text;
            $category = $request->category;
            $post = Post::findOrFail($id);
            $post->name = $name;
            $post->category = $category;
            $post->text = $text;
            $result = $post->save();
            if ($result) {
                return response()->json(array("result" => true, "msg" => "با موفقیت ذخیره شد"));
            } else {
                return response()->json(array("result" => false, "msg" => "خطا در ذخیره اطلاعات مجدد تلاش کنید!"));
            }
        } catch (Exception $ex) {
            return response()->json(array("result" => false, "msg" => "وارد کردن تمامی فیلدها اجباری است."));
        }
    }

    public function showPost($id) {
        $post = Post::findOrFail($id);
        return view("dashboard.post", array("post" => $post, "user" => session()->get("user")));
    }

    public function editPostPage($id) {
        $categories = Category::all();
        $post = Post::findorFail($id);
        return view("admin.posts.newPost", array("categories" => $categories, "post" => $post, "user" => session()->get("user")));
    }

    public function createPostPage() {
        $categories = Category::all();
        return view("admin.posts.newPost", array("categories" => $categories, "user" => session()->get("user")));
    }

}
