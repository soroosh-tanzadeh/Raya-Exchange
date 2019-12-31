<?php

use App\Http\Middleware\Authentication;
use Illuminate\Support\Facades\Crypt;
use Ixudra\Curl\Facades\Curl;
use App\Currency;
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

Route::get("/phpmigrate", function() {
    echo Artisan::call('migrate', [
        '--force' => true,
    ]);
});

Route::get("/test", function() {
    $response = Curl::to('https://currency.jafari.pw/json')
            ->get();
    $currencies = json_decode($response);
    $currencies = $currencies->Currency;
    foreach ($currencies as $currency) {
        $currency_db = Currency::where("code", $currency->Code)->first();
        if ($currency_db === null) {
            $currency_db = new Currency();
            $currency_db->code = $currency->Code;
            $currency_db->price = $currency->Sell;
            $currency_db->save();
        } else {
            $currency_db->code = $currency->Code;
            $currency_db->price = $currency->Sell;
            $currency_db->save();
        }
    }
});

Route::get("/encryp/{data?}", function ($data) {

    echo(Crypt::encryptString($data));
});

// Dashboard Route
Route::get("/usersfiles/{filename}", "DashboardController@getFile")->middleware(Authentication::class);
Route::get("/dashboard", "DashboardController@index")->middleware(Authentication::class);
// Tickets
Route::get("/dashboard/tickets", "DashboardController@tickets")->middleware(Authentication::class);
Route::get("/dashboard/tickets/new", "DashboardController@showNewTicket")->middleware(Authentication::class);
Route::get("/dashboard/ticket/{ticket_id}", "DashboardController@showTicket")->middleware(Authentication::class);
Route::post("/dashboard/ticket/newticket", "DashboardController@newTicket")->middleware(Authentication::class);
Route::post("/dashboard/ticket/{ticket_id}/sendmessage", "DashboardController@sendMessage")->middleware(Authentication::class);

// Market Cap
Route::get("/dashboard/market", "DashboardController@marketCap")->middleware(Authentication::class);
