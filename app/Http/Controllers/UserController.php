<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Crypt;
use App\Verification;
use App\SMS;
use Ixudra\Curl\Facades\Curl;
use App\Activity;
use App\Notification;

class UserController extends Controller {

    public function index(Request $request) {
        if (session()->has("user")) {
            if (session()->get("user")->is_admin) {
                return redirect("/admin");
            } else {
                return redirect("/dashboard");
            }
        } else {
            if ($request->has("wrong")) {
                return view("login", array("error" => true));
            } else {
                return view("login");
            }
        }
    }

    public function signupPage(Request $request) {
        return view("auth.signup", array("user" => session()->get("user")));
    }

    public function sendVcode(Request $request) {
        if ($request->input("type") === "phone") {
            $verificationCode = mt_rand(111111, 999999);
            $user = User::where("phone_number", $request->receiver)->first();
            if ($user === null) {
                $user = new User();
                $user->phone_number = $request->receiver;
                $user->save();
            }
            $code = new Verification();
            $code->code = $verificationCode;
            $code->user_id = $user->id;
            $code->expires_on = time() + 7200;
            $save = $code->save();
            $phone = $user->phone_number;
            $result = Curl::to("http://rayaex.webflax.ir/sendvcode?code=$verificationCode&phone=$phone&token=e5t9mxv2wzu3bmwzx0zymkgclofm78")->asJson()->get();
            session()->put("user_id", $user->id);
            return response()->json(array("result" => $result));
        }
    }

    public function verifyCode(Request $request) {
        $code = $request->code;
        $user_id = session()->get("user_id");
        $result = Verification::where("user_id", $user_id)->where("code", $code)->first();
        if ($result !== null) {
            $user = User::where("id", $user_id)->first();
            $verificationCode = mt_rand(1111111, 9999999);
            $result = Curl::to("http://rayaex.webflax.ir/sendpassword?code=$verificationCode&phone=$user->phone_number&token=e5t9mxv2wzu3bmwzx0zymkgclofm78")->asJson()->get();
            $user->password = Crypt::encryptString($verificationCode);
            $user->save();
            session()->put("user", $user);
            return response()->json(array("result" => true));
        } else {
            return response()->json(array("result" => false));
        }
    }

    public function signup(Request $request) {
        $name = $request->name;
        $address = $request->address;
        $province = $request->province;
        $city = $request->city;
        $postalcode = $request->postalcode;
        $affilate = $request->affilate;
        $nationalcode = $request->nationalcode;
        $password = $request->password;

        $fileBack = $request->file("fileBack")->store("files");
        $fileFront = $request->file("fileFront")->store("files");
        $fileSelfi = $request->file("selfiImage")->store("files");
        $usersfiles = array($fileBack, $fileFront, $fileSelfi);

        $user_id = session()->get("user")->id;

        $user = User::where("id", $user_id)->first();
        $user->name = $name;
        $user->address = $address;
        $user->province = $province;
        $user->city = $city;
        $user->nationalcode = $nationalcode;
        $user->affilate = $affilate;
        $user->postalcode = $postalcode;
        $user->files = json_encode($usersfiles);
        $user->password = Crypt::encryptString($password);

        if ($user->save()) {
            Notification::sendNotification("کاربر", "کاربر جدید در انتظار تایید", -1, "/users/$user->id");
            session()->put("user", $user);
            return redirect("/dashboard/?done");
        } else {
            return redirect("/dashboard/signup?error");
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
                Activity::addActivity("ورود به حساب");
                if ($user->is_admin) {
                    return redirect("/admin");
                }
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
