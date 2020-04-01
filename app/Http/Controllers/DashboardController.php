<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Ticket;
use Illuminate\Support\Facades\Storage;
use App\Common;
use GuzzleHttp\Client;
use App\Currency;
use Yajra\DataTables\DataTables;
use Ixudra\Curl\Facades\Curl;
use App\Wallet;
use App\Transaction;
use App\CoinOffer;
use App\Option;
use App\Activity;
use App\BankAccount;
use App\FaqCategory;
use App\coinPayments\CoinpaymentsAPI;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use App\TCategories;
use Illuminate\Support\Facades\Validator;
use Morilog\Jalali\Jalalian;
use App\SMS;
use App\WalletCoin;

class DashboardController extends Controller {

    public function index() {
        $currencyDATA = Curl::to("https://api.simpleswap.io/get_all_currencies")->asJson()->get();
        $currencies_all = array();
        if ($currencyDATA !== null) {
            foreach ($currencyDATA as $currency) {
                $currencies_all[$currency->symbol] = $currency;
            }
        }

        $currenciesData = (array) Curl::to("https://api.simpleswap.io/fixed/get_all_pairs")->asJson()->get();
        $currencies = array();
        foreach ($currenciesData as $key => $value) {
            $currencies[] = $currencies_all[$key];
        }

        $response = Cache::remember('coin-assets', 10000, function () {
                    $requestURL = "https://api.coincap.io/v2/assets";
                    return Curl::to($requestURL)
                                    ->asJson()
                                    ->get();
                });
        $offerablecoins = Wallet::where("type", "coin")->where("user_id", session()->get("user")->id)->get();
        $coins_raw = $response->data;
        $coins = array();
        $usdprice = Currency::where("code", "USD")->first()->price;
        foreach ($coins_raw as $coin) {
            $priceInToman = (int) ($coin->priceUsd * $usdprice);
            if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                $price = $priceInToman / 1000;
                $coin->price_in_toman = $price . " هزار تومان";
            } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                $price = $priceInToman / 1000000;
                $coin->price_in_toman = $price . " میلیون تومان";
            } elseif ($priceInToman >= 1000000000) {
                $price = $priceInToman / 1000000000;
                $coin->price_in_toman = $price . " میلیارد تومان";
            } else {
                $price = $priceInToman;
                $coin->price_in_toman = $price . " تومان";
            }
            $coin->price_in_toman_int = $priceInToman;
            $coins[$coin->id] = $coin;
        }

        $chart = Cache::remember('bitcoin-history', 10000, function () {
                    return Curl::to("https://api.coincap.io/v2/assets/bitcoin/history")
                                    ->withData(array('interval' => "d1"))
                                    ->asJson()
                                    ->get();
                });


        $chart = $chart->data;
        $outputChart = "[";
        foreach ($chart as $value) {
            $outputChart .= "{x: new Date($value->time),y: $value->priceUsd},";
        }
        $outputChart .= "]";
        $chart = Cache::remember('ethereum-history', 10000, function () {
                    return Curl::to("https://api.coincap.io/v2/assets/ethereum/history")
                                    ->withData(array('interval' => "d1"))
                                    ->asJson()
                                    ->get();
                });


        $chart = $chart->data;
        $liteoutputChart = "[";
        foreach ($chart as $value) {
            $liteoutputChart .= "{x: new Date($value->time),y: $value->priceUsd},";
        }

        $myoffers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("user_id", session()->get('user')->id)->select('users.name', 'coin_offers.*')->limit(10)->get();


        $liteoutputChart .= "]";
        $user = session()->get("user");
        $offers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("is_active", true)->where("is_selled", false)->where("user_id", "!=", $user->id)->select('users.name', 'coin_offers.*')->latest()->limit(10)->get();
        $buyoffers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("type", "buy")->where("is_active", true)->where("is_selled", false)->where("user_id", "!=", $user->id)->select('users.name', 'coin_offers.*')->latest()->paginate(25);
        $transactions = Transaction::where("user_id", $user->id)->limit(7)->get();

        return view("dashboard.index", array("user" => session()->get("user"), "myoffers" => $myoffers, "offerablecoins" => $offerablecoins, "coins" => $coins, "chart" => $outputChart, "litechart" => $liteoutputChart, "offers" => $offers, "buyoffers" => $buyoffers, "currencies" => $currencies, "transactions" => $transactions));
    }

    public function getUSD() {
        $usdprice = Currency::where("code", "USD")->first()->price;
        return response()->json(array("result" => true, "price" => $usdprice));
    }

    public function walletPage(Request $request) {
        $requestURL = "https://api.coincap.io/v2/assets";
        $response = Cache::remember('coin-assets', 10000, function () {
                    $requestURL = "https://api.coincap.io/v2/assets";
                    return Curl::to($requestURL)
                                    ->asJson()
                                    ->get();
                });
        $coins_raw = $response->data;
        $coins = array();
        $usdprice = Currency::where("code", "USD")->first()->price;
        foreach ($coins_raw as $coin) {
            $priceInToman = (int) ($coin->priceUsd * $usdprice);
            if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                $price = $priceInToman / 1000;
                $coin->price_in_toman = $price . '<span class="text-muted font-12" style="white-space: nowrap"> هزار تومان </span>';
            } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                $price = $priceInToman / 1000000;
                $coin->price_in_toman = $price . '<span class="text-muted font-12" style="white-space: nowrap"> میلیون تومان </span>';
            } elseif ($priceInToman >= 1000000000) {
                $price = $priceInToman / 1000000000;
                $coin->price_in_toman = $price . '<span class="text-muted font-12" style="white-space: nowrap"> میلیارد تومان </span>';
            } else {
                $price = $priceInToman;
                $coin->price_in_toman = $price . '<span class="text-muted font-12" style="white-space: nowrap"> تومان</span>';
            }
            $coin->price_in_toman_int = $priceInToman;
            $coins[$coin->symbol] = $coin;
        }
        $coinp = new CoinpaymentsAPI();
        $coinslistData = WalletCoin::all();
        $coinlist = array();
        foreach ($coinslistData as $wallet) {
            if (!Wallet::where("user_id", session()->get("user")->id)->where("name", $wallet->name)->exists()) {
                $coinslist[] = $wallet;
            }
        }
        $user = session()->get("user");
        $rialWallet = Wallet::where("user_id", $user->id)->where("type", "rial")->first();
        $coinWallets_data = Wallet::where("user_id", $user->id)->where("type", "coin")->get();
        $coinWallets = array();
        $wealth = 0;
        foreach ($coinWallets_data as $wallet) {
            $coinWallets[$wallet->type_name] = $wallet;
            if (isset($coins[strtoupper($wallet->type_name)])) {
                $wealth += $coins[strtoupper($wallet->type_name)]->priceUsd * $wallet->credit;
            }
        }



        $transactions = Transaction::where("user_id", $user->id)->limit(10)->get();
        //  return response()->json($coinp->GetRatesWithAccepted());
        return view("dashboard.wallet.index", array("usdprice" => $usdprice, "wealth" => $wealth, "user" => $user, "coinsprice" => $coins, "coins" => $coinslist, "coinWallets" => $coinWallets, "rialWallet" => $rialWallet, "transactions" => $transactions));
    }

    public function offerPage(Request $request) {
        $offerablecoins = Wallet::where("type", "coin")->where("user_id", session()->get("user")->id)->get();
        $response = Cache::remember('coin-assets', 10000, function () {
                    $requestURL = "https://api.coincap.io/v2/assets";
                    return Curl::to($requestURL)
                                    ->asJson()
                                    ->get();
                });
        $coins_raw = $response->data;
        $coins = array();
        $usdprice = Currency::where("code", "USD")->first()->price;
        foreach ($coins_raw as $coin) {
            $priceInToman = (int) ($coin->priceUsd * $usdprice);
            if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                $price = $priceInToman / 1000;
                $coin->price_in_toman = $price . " هزار تومان";
            } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                $price = $priceInToman / 1000000;
                $coin->price_in_toman = $price . " میلیون تومان";
            } elseif ($priceInToman >= 1000000000) {
                $price = $priceInToman / 1000000000;
                $coin->price_in_toman = $price . " میلیارد تومان";
            } else {
                $price = $priceInToman;
                $coin->price_in_toman = $price . " تومان";
            }
            $coin->price_in_toman_int = $priceInToman;
            $coins[$coin->id] = $coin;
        }

        $chart_btc = Cache::remember('bitcoin-history', 10000, function () {
                    return Curl::to("https://api.coincap.io/v2/assets/bitcoin/history")
                                    ->withData(array('interval' => "d1"))
                                    ->asJson()
                                    ->get();
                });
        $chart_ltc = Cache::remember('litecoin-history', 10000, function () {
                    return Curl::to("https://api.coincap.io/v2/assets/litecoin/history")
                                    ->withData(array('interval' => "d1"))
                                    ->asJson()
                                    ->get();
                });

        $chart_xrp = Cache::remember('litecoin-history', 10000, function () {
                    return Curl::to("https://api.coincap.io/v2/assets/ripple/history")
                                    ->withData(array('interval' => "d1"))
                                    ->asJson()
                                    ->get();
                });
        $bitcoinChart = $chart_btc->data;
        $litecoinChart = $chart_ltc->data;
        $ripplecoinChart = $chart_xrp->data;
        $outputChart = array("bitcoin" => "", "litecoin" => "", "ripple" => "");
        $usdprice = Currency::where("code", "USD")->first()->price;
        foreach ($bitcoinChart as $value) {
            $price = $usdprice * $value->priceUsd;
            $outputChart['bitcoin'] .= "[$price,";
        }
        $outputChart['bitcoin'] .= "]";
        foreach ($litecoinChart as $value) {
            $price = $usdprice * $value->priceUsd;
            $outputChart['litecoin'] .= "[$price,";
        }
        $outputChart['litecoin'] .= "]";
        foreach ($ripplecoinChart as $value) {
            $price = $usdprice * $value->priceUsd;
            $outputChart['ripple'] .= "[$price,";
        }
        $outputChart['ripple'] .= "]";

        $offers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("user_id", session()->get('user')->id)->select('users.name', 'coin_offers.*')->paginate(10);
        $buyoffers = CoinOffer::join("users", "users.id", "=", "coin_offers.buy_by")->where("is_active", true)->where("is_selled", true)->select('users.name', 'coin_offers.*')->limit(10)->get();
        $accounts = BankAccount::where("user_id", session()->get("user")->id)->get();

        $toRun = "";
        if ($request->has("error")) {
            $toRun = "<script> Swal.fire('خطا', '$request->error', 'error'); </script>";
        }

        return view("dashboard.offers.index", array("user" => session()->get("user"), "toRun" => $toRun, "offerablecoins" => $offerablecoins, "coins" => $coins, "chart" => $outputChart, "offers" => $offers, "buyoffers" => $buyoffers, "bankaccounts" => $accounts));
    }

    public function myoffers(Request $request) {
        $requestURL = "https://api.coincap.io/v2/assets";
        $response = Curl::to($requestURL)
                ->get();
        $coins_raw = json_decode($response)->data;
        $coins = array();
        $usdprice = Currency::where("code", "USD")->first()->price;
        foreach ($coins_raw as $coin) {
            $priceInToman = (int) ($coin->priceUsd * $usdprice);
            if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                $price = $priceInToman / 1000;
                $coin->price_in_toman = $price . " هزار تومان";
            } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                $price = $priceInToman / 1000000;
                $coin->price_in_toman = $price . " میلیون تومان";
            } elseif ($priceInToman >= 1000000000) {
                $price = $priceInToman / 1000000000;
                $coin->price_in_toman = $price . " میلیارد تومان";
            } else {
                $price = $priceInToman;
                $coin->price_in_toman = $price . " تومان";
            }
            $coin->price_in_toman_int = $priceInToman;

            $coins[$coin->id] = $coin;
        }

        $offers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("user_id", session()->get('user')->id)->select('users.name', 'coin_offers.*')->paginate(10);
        return view("dashboard.offers.myoffers", array("user" => session()->get("user"), "offers" => $offers, "coins" => $coins));
    }

    public function cancelOffer(Request $request) {
        $offer_id = $request->offer_id;
        $offer = CoinOffer::find($offer_id)->firstOrFail();
//        echo $offer->user_id;
//        echo ($offer->user_id === session()->get("user")->id);
//        echo session()->get("user")->id;
        if (intval($offer->user_id) === intval(session()->get("user")->id)) {
            if ($offer->type === "buy") {
                $user_id = session()->get("user")->id;
                $price = $offer->price_pre * $offer->amount;
                $wallet = Wallet::where("user_id", $user->id)->where("type", "rial")->first();
                $wallet->cashable += $price;
                $wallet->save();
                $offer = CoinOffer::find($offer_id)->firstOrFail();
                $offer->is_active = false;
                return response()->json(array("result" => $offer->save()));
            }
            $offer->is_active = false;
            return response()->json(array("result" => $offer->save()));
        } else {
            return abort(404);
        }
    }

    public function coinHistory24(Request $request) {
        $coinhis = Cache::remember("$request->coin-history", 10000, function () {
                    return Curl::to("https://api.coincap.io/v2/assets/$request->coin/history")
                                    ->withData(array('interval' => "m1"))
                                    ->asJson()
                                    ->get();
                });

        $output = "";
        $coinhis = $coinhis->data;
        foreach ($coinhis as $data) {
            $output .= $data->priceUsd;
        }
        return response()->json(array("result" => true, "data" => $output));
    }

    public function newoffer(Request $request) {
        if ($request->type == "buy") {
            $user = session()->get("user");
            $coin_type = $request->coin;
            $coin_num = $request->coinـnum;
            $price = str_replace(",", "", $request->price_toman);
            $minbuy = $request->mincoin;
            $wallet = Wallet::where("user_id", $user->id)->where("type", "rial")->first();
            if ($wallet->cashable >= $price) {
                $coin = new CoinOffer();
                $coin->user_id = session()->get("user")->id;
                $coin->amount = $coin_num;
                $coin->coin = $coin_type;
                $coin->price_pre = $price;
                $coin->min_buy = $minbuy;
                if ($minbuy > $coin_num) {
                    return response()->json(array("result" => false, "msg" => "حداقل فروش نمی‌تواند از مقدار بیشتر باشد!"));
                }
                $coin->max_buy = $coin_num;
                $coin->type = "buy";
                $wallet->cashable -= $price;
                if ($coin->save() && $wallet->save()) {
                    Activity::addActivity("ایجاد پیشنهاد خرید جدید");
                    return response()->json(array("result" => true, "msg" => "با موفقیت ایجاد شد"));
                } else {
                    return response()->json(array("result" => false, "msg" => "خطا در ذخیره اطلاعات"));
                }
            } else {
                return response()->json(array("result" => false, "msg" => "موجودی کیف پول ریالی شما کافی نیست"));
            }
        } elseif ($request->type == "sell") {
            $user = session()->get("user");
            $coin_type = $request->coin;
            $coin_num = $request->coinـnum;
            $price = str_replace(",", "", $request->price_toman);
            $minbuy = $request->mincoin;
            $wallet = Wallet::where("user_id", $user->id)->where("name", $coin_type)->first();
            if ($wallet->cashable >= $coin_num) {
                $coin = new CoinOffer();
                $coin->user_id = session()->get("user")->id;
                $coin->amount = $coin_num;
                $coin->coin = $coin_type;
                $coin->price_pre = $price;
                $coin->min_buy = $minbuy;
                if ($minbuy > $coin_num) {
                    return response()->json(array("result" => false, "msg" => "حداقل خرید نمی‌تواند از مقدار بیشتر باشد!"));
                }
                $coin->max_buy = $coin_num;
                $coin->type = "sell";
                $wallet->cashable -= $coin_num;

                if ($coin->save() && $wallet->save()) {
                    Activity::addActivity("ایجاد پیشنهاد فروش جدید");
                    return response()->json(array("result" => true, "msg" => "با موفقیت ایجاد شد"));
                } else {
                    return response()->json(array("result" => false, "msg" => "خطا در ذخیره اطلاعات"));
                }
            } else {
                return response()->json(array("result" => false, "msg" => "موجودی حساب کافی نیست"));
            }
        }
    }

    public function offersList(Request $request) {
        $user = session()->get("user");
        $requestURL = "https://api.coincap.io/v2/assets";
        $response = Curl::to($requestURL)
                ->get();
        $coins_raw = json_decode($response)->data;
        $coins = array();
        $usdprice = Currency::where("code", "USD")->first()->price;
        foreach ($coins_raw as $coin) {
            $priceInToman = (int) ($coin->priceUsd * $usdprice);
            if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                $price = $priceInToman / 1000;
                $coin->price_in_toman = $price . "<span class='text-muted font-toman'>هزار تومان</span>";
            } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                $price = $priceInToman / 1000000;
                $coin->price_in_toman = $price . "<span class='text-muted font-toman'>میلیون تومان</span>";
            } elseif ($priceInToman >= 1000000000) {
                $price = $priceInToman / 1000000000;
                $coin->price_in_toman = $price . "<span class='text-muted font-toman'>میلیارد تومان</span>";
            } else {
                $price = $priceInToman;
                $coin->price_in_toman = $price . "<span class='text-muted font-toman'> تومان</span>";
            }
            $coin->price_in_toman_int = $priceInToman;
            $coins[$coin->id] = $coin;
        }

        $start = (24 * 3600 * 30);
        $now = time();

        $chart = Curl::to("https://api.coincap.io/v2/assets/bitcoin/history")
                ->withData(array("start" => ($now - $start) * 1000, "end" => $now * 1000, "interval" => "d1"))
                ->asJson()
                ->get();
        $chart_btc = Curl::to("https://api.coincap.io/v2/assets/bitcoin/history")
                ->withData(array("start" => ($now - $start) * 1000, "end" => $now * 1000, "interval" => "d1"))
                ->asJson()
                ->get();
        $chart_ltc = Curl::to("https://api.coincap.io/v2/assets/litecoin/history")
                ->withData(array("start" => ($now - $start) * 1000, "end" => $now * 1000, "interval" => "d1"))
                ->asJson()
                ->get();
        $chart_xrp = Curl::to("https://api.coincap.io/v2/assets/ethereum/history")
                ->withData(array("start" => ($now - $start) * 1000, "end" => $now * 1000, "interval" => "d1"))
                ->asJson()
                ->get();

        $bitcoinChart = ($chart_btc)->data;
        $litecoinChart = ($chart_ltc)->data;
        $ripplecoinChart = ($chart_xrp)->data;
        $outputChart = array("bitcoin" => "", "litecoin" => "", "ethereum" => "");
        $usdprice = Currency::where("code", "USD")->first()->price;
        $outputChart['bitcoin'] .= "[";
        foreach ($bitcoinChart as $value) {
            $price = $usdprice * $value->priceUsd;
            $outputChart['bitcoin'] .= "{y: $price, x: $value->time},";
        }
        $outputChart['bitcoin'] .= "]";

        $outputChart['litecoin'] .= "[";
        foreach ($litecoinChart as $value) {
            $price = $usdprice * $value->priceUsd;
            $outputChart['litecoin'] .= "{y: $price, x: $value->time},";
        }
        $outputChart['litecoin'] .= "]";

        $outputChart['ethereum'] .= "[";
        foreach ($ripplecoinChart as $value) {
            $price = $usdprice * $value->priceUsd;
            $outputChart['ethereum'] .= "{y: $price, x: $value->time},";
        }
        $outputChart['ethereum'] .= "]";

        $offers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("type", "sell")->where("is_active", true)->where("is_selled", false)->where("user_id", "!=", $user->id)->select('users.name', 'coin_offers.*')->paginate(25);
        $buyoffers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("type", "buy")->where("is_active", true)->where("is_selled", false)->where("user_id", "!=", $user->id)->select('users.name', 'coin_offers.*')->paginate(25);
        return view("dashboard.offers.list", array("user" => session()->get("user"), "coins" => $coins, "chart" => $outputChart, "offers" => $offers, "buyoffers" => $buyoffers));
    }

    public function tickets(Request $request) {
        $user = session()->get("user");
        $tickets = Ticket::where("user_id", $user->id);
        if ($request->has("type")) {
            $tickets = $tickets->where("type", $request->type);
        }
        $tickets = $tickets->latest()->paginate(10);
        return view("dashboard.tickets.tickets", array("user" => session()->get("user"), "tickets" => $tickets));
    }

    public function showTicket($ticket_id) {
        $user = session()->get("user");
        $tickets = Ticket::where("user_id", $user->id)->where("id", $ticket_id)->first();
        return view("dashboard.tickets.ticketchat", array("user" => session()->get("user"), "ticket" => $tickets));
    }

    public function showNewTicket() {
        $user = session()->get("user");
        return view("dashboard.tickets.newticket", array("user" => session()->get("user")));
    }

    public function newWallet(Request $request) {
        $wallet = Wallet::where("user_id", session()->get("user")->id)->where("type_name", $request->type)->first();
        if ($wallet === null) {
            $wallet = new Wallet();
            $wallet->type = "coin";
            $wallet->type_name = $request->type;
            $wallet->name = $request->name;
            $wallet->cashable = 0;
            $wallet->credit = 0;
            $wallet->user_id = session()->get("user")->id;
            return response()->json(array("result" => $wallet->save(), "msg" => "با موفقیت انجام شد"));
        } else {
            return response()->json(array("result" => false, "msg" => "کیف پول وجود دارد"));
        }
    }

    public function sendMessage($ticket_id, Request $request) {
        $ticket = Ticket::where("id", $ticket_id)->first();
        if ($ticket !== null) {
            $files = array();
            if ($request->has($files)) {
                if (is_array($request->file('files'))) {
                    foreach ($request->file('files') as $file) {
                        $name = $file->getClientOriginalName();
                        $path = $file->store('files');
                        $files[] = array("link" => url("/$path"), "name" => $name);
                    }
                }
            }
            $ticket->type = 1;
            $ticket->status = "پاسخ کاربر";
            $ticket->addMessage($request->text, $files);
            $ticket->save();
            return response()->json(array("result" => true, "redirect" => "/dashboard/ticket/$ticket->id"));
        } else {
            return abort(404);
        }
    }

    public function getFile($filename, Request $request) {
        return Storage::download("files/$filename", $request->name, array());
    }

    // Type 1 - Waiting for Admin
    // Type 2 - Wating for User
    // Type 3 - Closed
    public function newTicket(Request $request) {
        $user = session()->get("user");
        $ticket = new Ticket();
        $ticket->user_id = $user->id;
        $ticket->name = $request->name;
        $ticket->status = "پاسخ کاربر";
        $ticket->priority = $request->priority;
        $ticket->to = $request->to;
        $ticket->type = 1;
        if ($ticket->save()) {
            $files = array();
            if ($request->hasFile('files')) {
//                $validator = Validator::make($request->all(), [
//                            'files' => 'mimes:jpeg,bmp,png,zip,rar,doc,docx,pdf'
//                ]);
//                if (true) {
                $attachments = $request->file('files');

                foreach ($attachments as $file) {
                    $name = $file->getClientOriginalName();
                    $path = $file->store('files');
                    $files[] = array("link" => url("/$path"), "name" => $name);
                }
//                } else {
//                    return response()->json(array("result" => false, "redirect" => "/dashboard/tickets/new", "msg" => "فرمت‌های مجاز - jpeg, bmp, png, zip, rar, doc, docx, pdf می‌باشید و حداکثر حجم مجاز ۱۰۰ مگابیت "));
//                }
            }
            $ticket->addMessage($request->text, $files);

            $sms = new SMS($user->phone_number);
            $sms->newTicekt($ticket->name);

            return response()->json(array("result" => true, "redirect" => "/dashboard/ticket/$ticket->id"));
        } else {
            return response()->json(array("result" => false, "redirect" => "/dashboard/tickets/new", "msg" => "خطا در ثبت اطلاعات"));
        }
    }

    public function changePass(Request $request) {
        $user = session()->get("user");
        $upass = Crypt::decryptString($user->password);
        $pass = $request->currentpass;
        if ("$upass" === "$pass") {
            $user = User::find($user->id);
            $password = $request->pass;
            $user->password = Crypt::encryptString($password);
            $user->save();
            return response()->json(array("result" => true, "msg" => "رمزعبور با موفقیت تغییر کرد!"));
        } else {
            return response()->json(array("result" => false, "msg" => "رمزعبور فعلی اشتباه است!"));
        }
    }

    public function changePassPge(Request $request) {
        return view("dashboard.pass", array("user" => session()->get("user")));
    }

    private $coin_index_id = '';

    public function getCoinPrice(Request $request) {
        $this->coin_index_id = $request->id;
        $response = Cache::remember("$request->id-assets", 10000, function () {
                    $requestURL = "https://api.coincap.io/v2/assets";
                    return Curl::to($requestURL)
                                    ->withData(array('ids' => $this->coin_id))
                                    ->asJson()
                                    ->get();
                });

        $coins = $response->data;
        $output = array();
        $usdprice = Currency::where("code", "USD")->first()->price;
        foreach ($coins as $coin) {
            $priceInToman = (int) ($coin->priceUsd * $usdprice);
            if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                $price = $priceInToman / 1000;
                $coin->price_in_toman = $price . "<br>" . "<div class='priceunit'>" . " هزار تومان" . "</div>";
            } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                $price = $priceInToman / 1000000;
                $coin->price_in_toman = $price . "<br>" . "<div class='priceunit'>" . " میلیون تومان" . "</div>";
            } elseif ($priceInToman >= 1000000000) {
                $price = $priceInToman / 1000000000;
                $coin->price_in_toman = $price . "<br>" . "<div class='priceunit'>" . " میلیارد تومان" . "</div>";
            } else {
                $price = $priceInToman;
                $coin->price_in_toman = $price . "<br>" . "<div class='priceunit'>" . " تومان" . "</div>";
            }

            $coin->price_in_toman_int = $priceInToman;
            $output[] = $coin;
            $coin->priceUsd = number_format(round($coin->priceUsd, 5), 5);
        }
        return response()->json($output[0]);
    }

    private $coin_id = '';

    public function getCoinPriceIndex(Request $request) {
        $this->coin_id = $request->id;
        $response = Cache::remember("$request->id-assets", 10000, function () {
                    $requestURL = "https://api.coincap.io/v2/assets";
                    return Curl::to($requestURL)
                                    ->withData(array('ids' => $this->coin_id))
                                    ->asJson()
                                    ->get();
                });
        $coins = $response->data;
        $output = array();
        $usdprice = Currency::where("code", "USD")->first()->price;
        foreach ($coins as $coin) {
            $priceInToman = (int) ($coin->priceUsd * $usdprice);
            if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                $price = $priceInToman / 1000;
                $coin->price_in_toman = $price . " هزار تومان";
            } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                $price = $priceInToman / 1000000;
                $coin->price_in_toman = $price . " میلیون تومان";
            } elseif ($priceInToman >= 1000000000) {
                $price = $priceInToman / 1000000000;
                $coin->price_in_toman = $price . " میلیارد تومان";
            } else {
                $price = $priceInToman;
                $coin->price_in_toman = $price . " تومان";
            }

            $coin->price_in_toman_int = $priceInToman;
            $output[] = $coin;
            $coin->priceUsd = number_format(round($coin->priceUsd, 5), 5);
        }
        return response()->json($output[0]);
    }

    private $market_page = 0;

    public function marketCap(Request $request) {
        $max = 100;
        $offset = 0;
        $this->market_page = 1;
        if ($request->has("page")) {
            $offset = ($request->page - 1) * 10;
            $this->market_page = $request->page;
        }
        $coins = Cache::remember("marketCap_page$this->market_page", 10000, function () {
                    return Curl::to("https://api.coingecko.com/api/v3/coins/markets")
                                    ->withData(array("vs_currency" => "usd", "per_page" => 10, "page" => $this->market_page, "price_change_percentage" => "7d,24h", "sparkline" => "true"))
                                    ->asJson()
                                    ->get();
                });

        $output = array();

        foreach ($coins as $coin) {
            $output[] = $coin;
        }

        return view("dashboard.market.coins", array("user" => session()->get("user"), "coins" => $output, "page" => $this->market_page));
    }

    private $coindetial_index = '';

    public function coinDetail(Request $request) {
        $this->coindetial_index = $request->coin;
        $json = Cache::remember("coinDetail-$request->coin", 10000, function () {
                    $start = 7300 * 8.64e+7;
                    $now = time() * 1000;
                    return Curl::to("https://api.coincap.io/v2/assets/$this->coindetial_index/history")
                                    ->withData(array("start" => $now - $start, "end" => $now, "interval" => "d1"))
                                    ->asJson()
                                    ->get();
                });

        if ($json->data !== null) {
            $data = $json->data;
            $output = array();
            foreach ($data as $value) {
                $output[] = array($value->time, round($value->priceUsd, 3));
            }
            return response()->json(array("result" => true, "data" => $output));
        } else {
            return response()->json(array("result" => false, "data" => null));
        }
    }

    public function faqPage(Request $request) {
        $categories = FaqCategory::all();
        return view("dashboard.faq", array("user" => session()->get("user"), "categories" => $categories));
    }

    public function tutorialPage(Request $request) {
        $categories = TCategories::all();
        return view("dashboard.tutorials", array("user" => session()->get("user"), "categories" => $categories));
    }

    public function getTickets(Request $request) {
        $user = session()->get("user");
        $tickets = Ticket::where("user_id", $user->id);
        if ($request->has("type")) {
            $tickets = $tickets->where("type", $request->type);
        }
        return DataTables::of($tickets)
                        ->editColumn("type", function($ticket) {
                            if ($ticket->type === '1') {
                                return "<span class=\"text-success\">$ticket->status</span>";
                            } elseif ($ticket->type === '2') {
                                return "<span class=\"text-warning\">$ticket->status</span>";
                            } else {
                                return "<span class=\"text-danger\">$ticket->status</span>";
                            }
                        })
                        ->addColumn("created_at", function($ticket) {
                            return Jalalian::forge($ticket->created_at)->ago();
                        })
                        ->addColumn("name", function ($ticket) {
                            return "<a href=\"/dashboard/ticket/$ticket->id\" class=\"link text-black\">$ticket->name</a>";
                        })
                        ->rawColumns(["type", "created_at", "name"])
                        ->make(true);
    }

}
