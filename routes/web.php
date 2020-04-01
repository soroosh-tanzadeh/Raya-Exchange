<?php

use App\Http\Middleware\Authentication;
use Illuminate\Support\Facades\Crypt;
use Ixudra\Curl\Facades\Curl;
use App\Currency;
use App\Http\Middleware\UserVerification;
use App\Http\Middleware\PostVerification;
use App\Http\Middleware\AdminMiddleware;
use App\Activity;
use Illuminate\Support\Facades\Storage;

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
Route::get("/admin-login", "UserController@adminLogin");

Route::get("/forgot-password", "UserController@passresetPage");
Route::post("/password-reset", "UserController@passReset");

Route::post("/dologin", "UserController@doLogin");
Route::post("/doadminlogin", "UserController@doAdminLgoin");

Route::get("/dashboard/signup", "UserController@signupPage")->middleware(Authentication::class);
Route::get("/dashboard/changeinfo", "UserController@changeinfoPage")->middleware(Authentication::class);

Route::post("/dochange", "UserController@changeInfo");
Route::post("/dosignup", "UserController@signup");
Route::post("/sendvcode", "UserController@sendVcode");

Route::post("newuser", "UserController@newUser");

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

Route::get("/getusdprice", "DashboardController@getUSD");

// Dashboard Route
Route::get("/files/{filename}", "DashboardController@getFile");
Route::get("/dashboard", "DashboardController@index")->middleware(Authentication::class);

// Tickets
Route::get("/dashboard/tickets", "DashboardController@tickets")->middleware(Authentication::class);
Route::get("/dashboard/tickets/new", "DashboardController@showNewTicket")->middleware(Authentication::class);
Route::get("/dashboard/ticket/{ticket_id}", "DashboardController@showTicket")->middleware(Authentication::class);
Route::post("/dashboard/ticket/newticket", "DashboardController@newTicket")->middleware(Authentication::class);
Route::post("/dashboard/ticket/{ticket_id}/sendmessage", "DashboardController@sendMessage")->middleware(Authentication::class);
Route::get('/dashboard/gettickets', 'DashboardController@getTickets')->middleware(Authentication::class);

// Market Cap
Route::get("/dashboard/market", "DashboardController@marketCap")->middleware(Authentication::class);
Route::post("/getcoin", "DashboardController@getCoinPrice")->middleware(Authentication::class);
Route::post("/getcoinIndex", "DashboardController@getCoinPriceIndex")->middleware(Authentication::class);

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

Route::get('/dashboard/profile', function() {
    return view("admin.users.profile", array("user" => session()->get("user"), "profile" => session()->get("user")));
})->middleware(Authentication::class);

Route::get('/notifications', function() {
    return view("includes.notification", array("user" => session()->get("user")));
})->middleware(Authentication::class);

//offers
Route::get('/dashboard/getbuyoffers', 'OffersController@getBuyOffers')->middleware(Authentication::class);
Route::get('/dashboard/getselloffers', 'OffersController@getSellOffers')->middleware(Authentication::class);

Route::get('/getpairs', 'ExchangeController@getPairs');
Route::get('/get_all_coins', 'ExchangeController@getAllCoins');

Route::get("/nopermission", function () {
    return view("admin.nopermission", array("user" => session()->get("user")));
});

///// DataTables
Route::get("/dashboard/gettransacions", "DataTablesController@transactions")->middleware(Authentication::class);
Route::get("/dashboard/coinpayments", "DataTablesController@coinpayments")->middleware(Authentication::class);
Route::get("/dashboard/deposits", "DataTablesController@deposits")->middleware(Authentication::class);

Route::get("/dashboard/rialpayments", "DataTablesController@rialpayments")->middleware(Authentication::class);
Route::get("/dashboard/rialdeposits", "DataTablesController@rialdeposits")->middleware(Authentication::class);
Route::get("/dashboard/getmyoffers", "DataTablesController@myoffers")->middleware(Authentication::class);
Route::get("/dashboard/affilatetransactions", "DataTablesController@affilatetransactions")->middleware(Authentication::class);
Route::get("/dashboard/affilatecheckouts", "DataTablesController@affilatecheckouts")->middleware(Authentication::class);
////// End DataTables
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

// Wait to verify
Route::get("/dashboard/notverified", function() {
    return view("dashboard.wait", array("user" => session()->get("user")));
})->middleware(Authentication::class);

//Notifications
Route::get("/readNotif", "NotificationsController@read")->middleware(Authentication::class);

Route::post("/coindetail", "DashboardController@coinDetail")->middleware(UserVerification::class);
Route::post("/dashboard/canceloffer", "DashboardController@cancelOffer")->middleware(UserVerification::class);

//FAQ
Route::get("/dashboard/faq", "DashboardController@faqPage")->middleware(Authentication::class);
Route::get("/dashboard/knowledge", "DashboardController@tutorialPage")->middleware(Authentication::class);

//Bank Account
Route::get("/dashboard/bankaccounts", "TransactionsController@bankAccounts")->middleware(UserVerification::class);
Route::post("/addccount", "TransactionsController@addBankAccount")->middleware(UserVerification::class);
Route::get("/dashboard/checkouts", "TransactionsController@checkouts")->middleware(UserVerification::class);
Route::post("/checkoutrequest", "TransactionsController@rialCheckouts")->middleware(UserVerification::class);
Route::post("/coin/checkoutrequest", "TransactionsController@coinCheckouts")->middleware(UserVerification::class);

Route::any("/getcoinhis", "DashboardController@coinHistory24")->middleware(UserVerification::class);

// Affilate 
Route::get("/dashboard/affilate", "AffilateController@index")->middleware(UserVerification::class);
Route::get("/dashboard/convert2btc", "AffilateController@convert2btc")->middleware(UserVerification::class);
Route::get("/dashboard/movetowallet", "AffilateController@moveToWallet")->middleware(UserVerification::class);



// Password 
Route::post("/dashboard/passchange", "DashboardController@changePass")->middleware(UserVerification::class);
Route::get("/dashboard/passchange", "DashboardController@changePassPge")->middleware(UserVerification::class);

Route::get("/images/{icon}", function ($icon) {
    return Storage::download("images/$icon");
});

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
    Route::post("/admin/ticket/newticket", "AdminController@newTicket");
    Route::get("/admin/ticket/close", "AdminController@closeTicket");
    Route::get("/admin/ticket/{ticket_id}", "AdminController@showTicket");
    Route::post("/admin/ticket/{ticket_id}/sendmessage", "AdminController@sendMessage");
    Route::get('/admin/gettickets', 'AdminController@getTickets');

    // Settings
    Route::get("/admin/settings", "AdminController@showSettings");
    Route::post("/admin/save-settings", "AdminController@saveOptions");

    // Admins 
    Route::get("/admin/admins", "AdminController@adminsPage");
    Route::post("/admin/admins/new", "AdminController@newAdmin");
    Route::post("/admin/admins/delete", "AdminController@deleteAdmin");


    //Alerts 
    Route::get("/admin/alerts", "AdminController@alertsPage");
    Route::post("/admin/alerts/new", "AdminController@newAlert");
    Route::post("/admin/alerts/delete", "AdminController@deactiveAlert");

    //FAQ
    Route::get("/admin/faq", "AdminController@faqPage");
    Route::post("/admin/newfaq", "AdminController@newQuestion");
    /// 
    Route::post("/admin/questions/delete", "FAQController@deleteQ");
    Route::post("/admin/categories/delete", "FAQController@deleteC");
    Route::post("/admin/categories/new", "FAQController@newC");


    Route::get("/admin/knowledge", "DashboardController@tutorialPage");

    Route::get("/admin/cryptopays", "AdminController@coinpayments");

    Route::get("admin/datatable/getrialpayments", "AdminController@getrialpayments");
    Route::get("admin/datatable/getrialdeposits", "AdminController@getrialdeposits");
    Route::get("admin/datatable/getcoindeposits", "AdminController@getcoindeposits");


    Route::get("/admin/getusers", "AdminController@getUsers");
    Route::get("/admin/gettransactions", "AdminController@getTransactions");
    Route::get("/admin/getbankaccounts", "AdminController@getBankAccounts");

    Route::get("/admin/transactions", "AdminController@transactions");

    Route::get("/admin/offers", "AdminController@offers");

    Route::get('/admin/getbuyoffers', 'OffersController@getAdminBuyOffers');
    Route::get('/admin/getselloffers', 'OffersController@getAdminSellOffers');


    Route::post("/admin/activeuser", "AdminController@activeUser");
    Route::post("/admin/deactiveuser", "AdminController@deactiveUser");

    Route::post("/admin/edituser", "AdminController@editUser");

    Route::get('/adminnotifications', function() {
        return view("includes.adminnotification");
    });

    Route::post("/admin/editadmin", "AdminController@editAdmin");

    Route::post("/admin/activeoffer", "AdminController@activeOffer");
    Route::post("/admin/deactiveoffer", "AdminController@deactiveOffer");

    Route::get('/admin/profile', function() {
        return view("admin.users.profile", array("user" => session()->get("user_admin"), "profile" => session()->get("user_admin")));
    });

    // Password 
    Route::post("/admin/passchange", "AdminController@changePass");
    Route::get("/admin/passchange", "AdminController@changePassPge");
});
