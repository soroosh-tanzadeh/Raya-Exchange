<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Crypt;
use App\Verification;
use Ixudra\Curl\Facades\Curl;
use App\Activity;
use App\Notification;
use App\Wallet;
use App\BankAccount;

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
            } elseif ($request->has("notactive")) {
                return view("login", array("torun" => ' toastr["error"]("حساب شما از سمت مدیریت مسدود شده!", "خطا");'));
            } else {
                $vars = array();
                if ($request->has("user_referral_id")) {
                    session()->put("user_referral_id", $request->user_referral_id);
                    $vars = array("user_referral_id" => $request->user_referral_id);
                }
                return view("login", $vars);
            }
        }
    }

    public function adminLogin(Request $request) {
        if (session()->has("user_admin")) {
            return redirect("/admin");
        } else {
            if ($request->has("wrong")) {
                return view("admin-login", array("error" => true));
            } else {
                return view("admin-login");
            }
        }
    }

    public function signupPage(Request $request) {
        if ($request->has("noaccess")) {
            return view("auth.signup", array("user" => session()->get("user"), "alert" => true));
        } else {
            return view("auth.signup", array("user" => session()->get("user"), "alert" => false));
        }
    }

    public function changeinfoPage(Request $request) {
        if ($request->has("noaccess")) {
            return view("auth.change-info", array("user" => session()->get("user"), "alert" => true));
        } else {
            return view("auth.change-info", array("user" => session()->get("user"), "alert" => false));
        }
    }

    public function passresetPage(Request $request) {
        return view("forgot-password");
    }

    public function passReset(Request $request) {
        $code = $request->code;
        $user_id = session()->get("user_id");
        $result = Verification::where("user_id", $user_id)->where("code", $code)->first();
        if ($result !== null) {
            $user = User::where("id", $user_id)->first();
            $user->password = Crypt::encryptString($request->password);
            $user->active = true;
            $user->is_admin = false;
            $user->save();
            session()->put("user", $user);
            return response()->json(array("result" => true));
        } else {
            return response()->json(array("result" => false));
        }
    }

    public function sendVcode(Request $request) {
        if ($request->input("type") === "phone") {
            $verificationCode = mt_rand(10000, 99999);
            $user = User::where("phone_number", $request->receiver)->first();
            if ($user === null) {
                return response()->json(array("result" => false));
            }
            $code = new Verification();
            $code->code = $verificationCode;
            $code->user_id = $user->id;
            $code->expires_on = time() + 7200;
            $save = $code->save();
            $phone = $user->phone_number;
            if ($request->has("user_referral_id")) {
                $afilate = session()->pull("user_referral_id");
                $user->affilate = $afilate;
            }

            $result = Curl::to("http://rayaex.webflax.ir/SMSService/sendvcode?code=$verificationCode&phone=$phone&token=e5t9mxv2wzu3bmwzx0zymkgclofm78")->asJson()->get();
            session()->put("user_id", $user->id);
            return response()->json(array("result" => $result));
        }
    }

    public function newUser(Request $request) {
        if ($request->input("type") === "phone") {
            $verificationCode = mt_rand(10000, 99999);
            $user = User::where("phone_number", $request->receiver)->first();
            if ($user === null) {
                $user = new User();
                $user->phone_number = $request->receiver;
                $user->name = $request->name;
                $user->active = false;
                $user->password = Crypt::encryptString($request->password);
                if (session()->has("user_referral_id")) {
                    $afilate = session()->pull("user_referral_id");
                    $user->affilate = $afilate;
                }
                $user->save();
            } else {
                return response()->json(array("result" => false));
            }
            $code = new Verification();
            $code->code = $verificationCode;
            $code->user_id = $user->id;
            $code->expires_on = time() + 7200;
            $save = $code->save();
            $phone = $user->phone_number;

            $result = Curl::to("http://rayaex.webflax.ir/SMSService/sendvcode?code=$verificationCode&phone=$phone&token=e5t9mxv2wzu3bmwzx0zymkgclofm78")->asJson()->get();
            session()->put("user_id", $user->id);

            UserController::checkWallets($user);

            return response()->json(array("result" => $result));
        }
    }

    public function verifyCode(Request $request) {
        $code = $request->code;
        $user_id = session()->get("user_id");
        $result = Verification::where("user_id", $user_id)->where("code", $code)->first();
        if ($result !== null) {
            $user = User::where("id", $user_id)->first();
            $user->active = true;
            $user->is_admin = false;
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
        $nationalcode = $request->nationalcode;
        $password = $request->password;
        $telephone = $request->telephone;
        $email = $request->email;

        $fileBack = $request->file("fileBack")->store("files");
        $fileFront = $request->file("fileFront")->store("files");
        $fileSelfi = $request->file("selfiImage")->store("files");

        $card_picture = $request->file("creditcardpic")->store("files");

        $usersfiles = array($fileBack, $fileFront, $fileSelfi);

        $user_id = session()->get("user")->id;

        $user = User::where("id", $user_id)->first();
        $user->name = $name;
        $user->address = $address;
        $user->province = $province;
        $user->city = $city;
        $user->telephone = $telephone;
        $user->nationalcode = $nationalcode;
        $user->postalcode = $postalcode;
        $user->postalcode = $postalcode;
        $user->verified_at = null;
        $user->is_admin = false;
        $user->permissions = null;
        $user->email_verified_at = null;
        $user->files = json_encode($usersfiles);
        $user->email = $email;

        $account = new BankAccount();
        $account->IBAN = $request->IBAN;
        $account->account_number = $request->account_number;
        $account->card_number = $request->card_number;
        $account->user_id = $user->id;
        $account->owner = $user->account_owner;
        $account->card_picture = $card_picture;
        $account->save();

        if ($user->save()) {
            Notification::sendNotification("کاربر", "کاربر جدید در انتظار تایید", -1, "/users/$user->id");
            session()->put("user", $user);
            return redirect("/dashboard/notverified");
        } else {
            return redirect("/dashboard/signup?error");
        }
    }

    public function changeInfo(Request $request) {
        $address = $request->address;
        $province = $request->province;
        $city = $request->city;
        $postalcode = $request->postalcode;
        $telephone = $request->telephone;
        $email = $request->email;

        $user_id = session()->get("user")->id;

        $user = User::where("id", $user_id)->first();
        $user->address = $address;
        $user->province = $province;
        $user->city = $city;
        $user->telephone = $telephone;
        $user->postalcode = $postalcode;
        $user->is_admin = false;
        $user->permissions = null;
        if ($user->email !== $email) {
            $user->email_verified_at = null;
            $user->email = $email;
        }

        if ($user->save()) {
            session()->put("user", $user);
            return redirect("/dashboard/");
        } else {
            return redirect("/dashboard/");
        }
    }

    public function doLogin(Request $request) {
        $email = $request->input("email");
        $pass = $request->input("password");
        $user = User::where("phone_number", $email)->orWhere("email", $email)->where("active", true)->first();
        $respons = array("result" => 1);
        if ($user !== null) {
            $upass = Crypt::decryptString($user->password);
            if ($upass === $pass) {
                if ($user->active && !$user->is_admin) {
                    session()->put("user", $user);
                    Activity::addActivity("ورود به حساب");
                    UserController::checkWallets($user);
                    return redirect("/dashboard");
                } else {
                    return $this->loginError();
                }
            } else {
                return $this->loginError();
            }
        } else {
            return $this->loginError();
        }
    }

    public function doAdminLgoin(Request $request) {
        $email = $request->input("email");
        $pass = $request->input("password");
        $user = User::where("phone_number", $email)->orWhere("email", $email)->where("active", true)->where("is_admin", true)->first();
        $respons = array("result" => 1);
        if ($user !== null) {
            $upass = Crypt::decryptString($user->password);
            if ($upass === $pass) {
                session()->put("user_admin", $user);
                Activity::addActivity("ورود به حساب");
                if ($user->is_admin) {
                    return redirect("/admin");
                    UserController::checkWallets($user);
                } else {
                    return redirect("/?notactive");
                }
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

    public static function checkWallets($user) {
        /// Check Wallets 
        $wallets = array("btc" => "Bitcoin", "eth" => "Ethereum", "ltc" => "Litecoin", "xrp" => "Ripple", "usdt" => "Tether", "bch" => "Bitcoin Cash");
        foreach ($wallets as $key => $value) {
            if (!(Wallet::where("type_name", $key)->where("user_id", $user->id)->first() instanceof Wallet)) {
                $wallet = new Wallet();
                $wallet->type = "coin";
                $wallet->type_name = $key;
                $wallet->name = $value;
                $wallet->cashable = 0;
                $wallet->credit = 0;
                $wallet->user_id = $user->id;
                $wallet->save();
            }
        }

        $rialwallet = Wallet::where("type_name", "Rial")->where("user_id", $user->id)->first();
        if (!Wallet::where("type_name", "Rial")->where("user_id", $user->id)->exists()) {
            $rialwallet = new Wallet();
            $rialwallet->type = "rial";
            $rialwallet->type_name = "Rial";
            $rialwallet->name = "تومان";
            $rialwallet->cashable = 0;
            $rialwallet->credit = 0;
            $rialwallet->user_id = $user->id;
            $rialwallet->save();
        }
        // End Check Wallets
    }

    public function checkIBAN($iban) {
        $iban = strtolower(str_replace(' ', '', $iban));
        $Countries = array("ir" => 26, 'al' => 28, 'ad' => 24, 'at' => 20, 'az' => 28, 'bh' => 22, 'be' => 16, 'ba' => 20, 'br' => 29, 'bg' => 22, 'cr' => 21, 'hr' => 21, 'cy' => 28, 'cz' => 24, 'dk' => 18, 'do' => 28, 'ee' => 20, 'fo' => 18, 'fi' => 18, 'fr' => 27, 'ge' => 22, 'de' => 22, 'gi' => 23, 'gr' => 27, 'gl' => 18, 'gt' => 28, 'hu' => 28, 'is' => 26, 'ie' => 22, 'il' => 23, 'it' => 27, 'jo' => 30, 'kz' => 20, 'kw' => 30, 'lv' => 21, 'lb' => 28, 'li' => 21, 'lt' => 20, 'lu' => 20, 'mk' => 19, 'mt' => 31, 'mr' => 27, 'mu' => 30, 'mc' => 27, 'md' => 24, 'me' => 22, 'nl' => 18, 'no' => 15, 'pk' => 24, 'ps' => 29, 'pl' => 28, 'pt' => 25, 'qa' => 29, 'ro' => 24, 'sm' => 27, 'sa' => 24, 'rs' => 22, 'sk' => 24, 'si' => 19, 'es' => 24, 'se' => 24, 'ch' => 21, 'tn' => 24, 'tr' => 26, 'ae' => 23, 'gb' => 22, 'vg' => 24);
        $Chars = array('a' => 10, 'b' => 11, 'c' => 12, 'd' => 13, 'e' => 14, 'f' => 15, 'g' => 16, 'h' => 17, 'i' => 18, 'j' => 19, 'k' => 20, 'l' => 21, 'm' => 22, 'n' => 23, 'o' => 24, 'p' => 25, 'q' => 26, 'r' => 27, 's' => 28, 't' => 29, 'u' => 30, 'v' => 31, 'w' => 32, 'x' => 33, 'y' => 34, 'z' => 35);

        if (strlen($iban) == $Countries[substr($iban, 0, 2)]) {
            $MovedChar = substr($iban, 4) . substr($iban, 0, 4);
            $MovedCharArray = str_split($MovedChar);
            $NewString = "";

            foreach ($MovedCharArray AS $key => $value) {
                if (!is_numeric($MovedCharArray[$key])) {
                    $MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
                }
                $NewString .= $MovedCharArray[$key];
            }

            if (bcmod($NewString, '97') == 1) {
                return true;
            }
        }
        return false;
    }

    public function checkCartDigit($code) {
        $L = strlen($code);
        if ($L < 16 || intval(substr($L, 1, 10), 10) == 0 || intval(substr($code, 10, 6), 10) == 0)
            return false;
        $c = intval(substr($code, 15, 1), 10);
        $s = 0;
        $k = 0;
        $d = 0;
        for ($i = 0; $i < 16; $i++) {
            $k = ($i % 2 == 0) ? 2 : 1;
            $d = intval(substr($code, $i, 1), 10) * $k;
            $s += ($d > 9) ? $d - 9 : $d;
        }
        return (($s % 10) == 0);
    }

}
