<?php

use App\Http\Middleware\Authentication;
use Illuminate\Support\Facades\Crypt;
use Ixudra\Curl\Facades\Curl;
use App\Currency;
use App\Http\Middleware\UserVerification;
use App\Http\Middleware\PostVerification;

use App\Http\Middleware\AdminMiddleware;
use App\Activity;

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



/**
 * Users Routers
 */
Route::get("/", "UserController@index");
Route::post("/dologin", "UserController@doLogin");
Route::get("/dashboard/signup", "UserController@signupPage")->middleware(Authentication::class);
Route::post("/dosignup", "UserController@signup");
Route::post("/sendvcode", "UserController@sendVcode");
Route::post("/verifyUser", "UserController@verifyCode");
Route::get("/logout", function () {
    Activity::addActivity("خروج از حساب");
    session()->remove("user");
    return redirect("/");
})->middleware(Authentication::class);

Route::get("/phpmigrate", function() {
    echo Artisan::call('migrate', [
        '--force' => true,
    ]);
});

//
//Route::get("/encryp/{data?}", function ($data) {
//    echo(Crypt::encryptString($data));
//});

Route::get("/getusdprice", "DashboardController@getUSD");

// Dashboard Route
Route::get("/files/{filename}", "DashboardController@getFile")->middleware(Authentication::class);
Route::get("/dashboard", "DashboardController@index")->middleware(Authentication::class);

// Tickets
Route::get("/dashboard/tickets", "DashboardController@tickets")->middleware(Authentication::class);
Route::get("/dashboard/tickets/new", "DashboardController@showNewTicket")->middleware(Authentication::class);
Route::get("/dashboard/ticket/{ticket_id}", "DashboardController@showTicket")->middleware(Authentication::class);
Route::post("/dashboard/ticket/newticket", "DashboardController@newTicket")->middleware(Authentication::class);
Route::post("/dashboard/ticket/{ticket_id}/sendmessage", "DashboardController@sendMessage")->middleware(Authentication::class);

// Market Cap
Route::get("/dashboard/market", "DashboardController@marketCap")->middleware(Authentication::class);
Route::post("/getcoin", "DashboardController@getCoinPrice")->middleware(Authentication::class);

// Wallet 
Route::get("/dashboard/mywallet", "DashboardController@walletPage")->middleware(UserVerification::class);
Route::post("/dashboard/newwallet", "DashboardController@newWallet")->middleware(UserVerification::class);

// Payment
Route::get("/dashboard/buyoffer", "DashboardController@offerPage")->middleware(Authentication::class);

Route::any('/dashboard/newoffer/', 'DashboardController@newoffer')->middleware(UserVerification::class);
Route::post('/dashboard/newbuyoffer', 'DashboardController@newofferBuy')->middleware(UserVerification::class);
Route::get('/dashboard/offers/', 'DashboardController@offersList')->middleware(UserVerification::class);
Route::get('/dashboard/myoffers/', 'DashboardController@myoffers')->middleware(UserVerification::class);
Route::get('/dashboard/exchange', 'ExchangeController@index')->middleware(Authentication::class);
Route::post("/exchange", "ExchangeController@exchangeRequest")->middleware(PostVerification::class);
Route::get("/get_estimate", "ExchangeController@getEstimate")->middleware(Authentication::class);
Route::get('/dashboard/crypto', 'TransactionsController@crypto')->middleware(UserVerification::class);
Route::get('/dashboard/rials', 'TransactionsController@rials')->middleware(UserVerification::class);
Route::get('/dashboard/offerpage', 'PaymentController@offerPage')->middleware(UserVerification::class);


//offers
Route::get('/dashboard/getbuyoffers', 'OffersController@getBuyOffers')->middleware(UserVerification::class);
Route::get('/dashboard/getselloffers', 'OffersController@getSellOffers')->middleware(UserVerification::class);


Route::get('/allcoins', 'ExchangeController@getcoins');


// Payments
Route::get('/payir/callback', 'PaymentController@verify');
Route::get('/payir/pay', 'PaymentController@pay')->middleware(UserVerification::class);
Route::get("/buycoin", "PaymentController@buyCoin")->middleware(UserVerification::class);
Route::post("/coinwebhook", "PaymentController@webhook");
Route::post("/coincallback", "PaymentController@comfirm")->middleware(UserVerification::class);
Route::get("/paycoin", "PaymentController@payCoin")->middleware(UserVerification::class);

Route::get("/assets/icons/{iconfile}", function($iconfile) {
    return redirect("/assets/img/raya-logo.png");
})->middleware(Authentication::class);

//Route::get("/test", function() {
//    $coinp = new App\coinPayments\CoinpaymentsAPI();
//    return response()->json($coinp->GetRatesWithAccepted());
//})->middleware(Authentication::class);


// Wait to verify
Route::get("/dashboard/notverified", function() {
    return view("dashboard.wait", array("user" => session()->get("user")));
})->middleware(Authentication::class);


//Notifications
Route::get("/readNotif", "NotificationsController@read")->middleware(UserVerification::class);

Route::post("/coindetail", "DashboardController@coinDetail")->middleware(UserVerification::class);
Route::post("/dashboard/canceloffer", "DashboardController@cancelOffer")->middleware(UserVerification::class);

//FAQ
Route::get("/dashboard/faq", "DashboardController@faqPage")->middleware(Authentication::class);
Route::get("/dashboard/knowledge", "DashboardController@knowledgePage")->middleware(Authentication::class);


//Bank Account
Route::get("/dashboard/bankaccounts", "TransactionsController@bankAccounts")->middleware(UserVerification::class);
Route::post("/addccount", "TransactionsController@addBankAccount")->middleware(UserVerification::class);
Route::get("/dashboard/checkouts", "TransactionsController@checkouts")->middleware(UserVerification::class);
Route::post("/checkoutrequest", "TransactionsController@rialCheckouts")->middleware(UserVerification::class);
Route::post("/coin/checkoutrequest", "TransactionsController@coinCheckouts")->middleware(UserVerification::class);

Route::any("/getcoinhis", "DashboardController@coinHistory24")->middleware(UserVerification::class);


// Affilate 
Route::get("/dashboard/affilate", "AffilateController@index")->middleware(UserVerification::class);


/**
 * End Users Routers
 */
Route::middleware(AdminMiddleware::class)->group(function () {
    Route::get("/admin", "AdminController@index");

    // Users
    Route::get("/admin/users", "AdminController@users");
    Route::get("/admin/users/{user_id}", "AdminController@userProfile");
    Route::post("/admin/verifyuser", "AdminController@verifyUser");

    // Payment
    Route::get("/admin/rialpays", "AdminController@rialpayments");
    Route::get("/admin/bankaccounts", "AdminController@bankAccountsPage");
    Route::post("/admin/comfirmcoinpay", "AdminController@comfirmCoinReceive");
    Route::post("/admin/comfirmpayment", "AdminController@comfirmPayment");
    Route::post("/admin/comfirmbankaccount", "AdminController@verifyBankAccount");
    Route::post("/admin/comfirmpay", "AdminController@comfirmPayment");

    // Tickets
    Route::get("/admin/tickets", "AdminController@tickets");
    Route::get("/admin/tickets/new", "AdminController@showNewTicket");
    Route::get("/admin/ticket/{ticket_id}", "AdminController@showTicket");
    Route::post("/admin/ticket/newticket", "AdminController@newTicket");
    Route::post("/admin/ticket/{ticket_id}/sendmessage", "AdminController@sendMessage");

    //FAQ
    Route::get("/admin/faq", "AdminController@faqPage");
    Route::post("/admin/newfaq", "AdminController@newQuestion");
});
