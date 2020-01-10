<?php

use App\Http\Middleware\Authentication;
use Illuminate\Support\Facades\Crypt;
use Ixudra\Curl\Facades\Curl;
use App\Currency;
use App\Http\Middleware\UserVerification;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get("/", "UserController@index");
Route::post("/dologin", "UserController@doLogin");

Route::get("/dashboard/signup", "UserController@signupPage")->middleware(Authentication::class);
Route::post("/dosignup", "UserController@signup");
Route::post("/sendvcode", "UserController@sendVcode");

Route::get("/phpmigrate", function() {
    echo Artisan::call('migrate', [
        '--force' => true,
    ]);
});

//Route::get("/test", function() {
//    $response = Curl::to('https://currency.jafari.pw/json')
//            ->get();
//    $currencies = json_decode($response);
//    $currencies = $currencies->Currency;
//    foreach ($currencies as $currency) {
//        $currency_db = Currency::where("code", $currency->Code)->first();
//        if ($currency_db === null) {
//            $currency_db = new Currency();
//            $currency_db->code = $currency->Code;
//            $currency_db->price = $currency->Sell;
//            $currency_db->save();
//        } else {
//            $currency_db->code = $currency->Code;
//            $currency_db->price = $currency->Sell;
//            $currency_db->save();
//        }
//    }
//});

Route::get("/encryp/{data?}", function ($data) {
    echo(Crypt::encryptString($data));
});

// Dashboard Route
Route::get("/usersfiles/{filename}", "DashboardController@getFile")->middleware(Authentication::class);
Route::get("/dashboard", "DashboardController@index")->middleware(UserVerification::class);

// Tickets
Route::get("/dashboard/tickets", "DashboardController@tickets")->middleware(Authentication::class);
Route::get("/dashboard/tickets/new", "DashboardController@showNewTicket")->middleware(Authentication::class);
Route::get("/dashboard/ticket/{ticket_id}", "DashboardController@showTicket")->middleware(Authentication::class);
Route::post("/dashboard/ticket/newticket", "DashboardController@newTicket")->middleware(Authentication::class);
Route::post("/dashboard/ticket/{ticket_id}/sendmessage", "DashboardController@sendMessage")->middleware(Authentication::class);

// Market Cap
Route::get("/dashboard/market", "DashboardController@marketCap")->middleware(Authentication::class);

// Wallet 
Route::get("/dashboard/mywallet", "DashboardController@walletPage")->middleware(UserVerification::class);

// Payment
Route::get("/dashboard/buyoffer", "DashboardController@offerPage")->middleware(UserVerification::class);
Route::post('/dashboard/newoffer/', 'DashboardController@newoffer')->middleware(UserVerification::class);
Route::get('/dashboard/offers/', 'DashboardController@offersList')->middleware(UserVerification::class);
Route::get('/dashboard/exchange', 'ExchangeController@index')->middleware(UserVerification::class);
Route::post("/exchange", "ExchangeController@exchangeRequest")->middleware(UserVerification::class);
Route::get("/get_estimate", "ExchangeController@getEstimate");
Route::get('/dashboard/crypto', 'TransactionsController@crypto')->middleware(UserVerification::class);
Route::get('/dashboard/rials', 'TransactionsController@rials')->middleware(UserVerification::class);


// Payments
Route::get('/payir/callback', 'PaymentController@verify');
Route::get('/payir/pay', 'PaymentController@pay')->middleware(UserVerification::class);
Route::get("/buycoin", "PaymentController@buyCoin")->middleware(UserVerification::class);
Route::post("/coinwebhook", "PaymentController@webhook");
Route::post("/coincallback", "PaymentController@comfirm")->middleware(UserVerification::class);
Route::get("/paycoin", "PaymentController@payCoin")->middleware(UserVerification::class);

Route::post("/verifyUser", "UserController@verifyCode");

// Wait to verify
Route::get("/dashboard/notverified", function() {
    return view("dashboard.wait", array("user" => session()->get("user")));
})->middleware(Authentication::class);


//Notifications
Route::get("/readNotif", "NotificationsController@read")->middleware(UserVerification::class);
Route::get("/logout", function () {
    session()->remove("user");
    return redirect("/");
})->middleware(Authentication::class);
