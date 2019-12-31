<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller {

    public function index(Request $request) {
        if (session()->has("user")) {
            redirect("/dashboard");
        } else {
            if ($request->has("wrong")) {
                return view("login",array("error" => true));
            } else {
                return view("login");
            }
        }
    }

    public function doLogin(Request $request) {
        $email = $request->input("email");
        $pass = $request->input("password");
        $user = User::where("email", $email)->first();
        $respons = array("result" => 1);
        if ($user !== null) {
            $upass = Crypt::decryptString($user->password);
            if ($upass === $pass) {
                session()->put("user", $user);
                return redirect("/dashboard");
            } else {
                return $this->loginError();
            }
        } else {
            return $this->loginError();
        }
    }

    public function loginError() {
       return redirect("/?wrong");
    }

}
