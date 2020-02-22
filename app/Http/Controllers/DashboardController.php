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

class DashboardController extends Controller {

    public function index() {
        $currencies = Curl::to("https://api.simpleswap.io/get_all_currencies")->asJson()->get();
        $requestURL = "https://api.coincap.io/v2/assets";
        $response = Curl::to($requestURL)
                ->get();
        $offerablecoins = Wallet::where("type", "coin")->where("user_id", session()->get("user")->id)->get();
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

        $chart = Curl::to("https://api.coincap.io/v2/assets/bitcoin/history")
                ->withData(array('interval' => "d1"))
                ->get();
        $chart = json_decode($chart)->data;
        $outputChart = "[";
        foreach ($chart as $value) {
            $outputChart .= "{x: new Date($value->time),y: $value->priceUsd},";
        }
        $outputChart .= "]";
        $chart = Curl::to("https://api.coincap.io/v2/assets/ethereum/history")
                ->withData(array('interval' => "d1"))
                ->get();
        $chart = json_decode($chart)->data;
        $liteoutputChart = "[";
        foreach ($chart as $value) {
            $liteoutputChart .= "{x: new Date($value->time),y: $value->priceUsd},";
        }
        $liteoutputChart .= "]";
        $user = session()->get("user");
        $offers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("is_active", true)->where("is_selled", false)->where("user_id", "!=", $user->id)->select('users.name', 'coin_offers.*')->latest()->limit(10)->get();
        $buyoffers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("type", "buy")->where("is_active", true)->where("is_selled", false)->where("user_id", "!=", $user->id)->select('users.name', 'coin_offers.*')->latest()->paginate(25);
        $transactions = Transaction::where("user_id", $user->id)->limit(7)->get();

        return view("dashboard.index", array("user" => session()->get("user"), "offerablecoins" => $offerablecoins, "coins" => $coins, "chart" => $outputChart, "litechart" => $liteoutputChart, "offers" => $offers, "buyoffers" => $buyoffers, "currencies" => $currencies, "transactions" => $transactions));
    }

    public function getUSD() {
        $usdprice = Currency::where("code", "USD")->first()->price;
        return response()->json(array("result" => true, "price" => $usdprice));
    }

    public function walletPage(Request $request) {
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
        $coinp = new CoinpaymentsAPI();
        $coinslist = $coinp->GetRatesWithAccepted()['result'];
        $user = session()->get("user");
        $rialWallet = Wallet::where("user_id", $user->id)->where("type", "rial")->first();
        $coinWallets_data = Wallet::where("user_id", $user->id)->where("type", "coin")->get();
        $coinWallets = array();
        foreach ($coinWallets_data as $wallet) {
            $coinWallets[$wallet->type_name] = $wallet;
        }
        $transactions = Transaction::where("user_id", $user->id)->limit(10)->get();
        return view("dashboard.wallet.index", array("user" => $user,"coinsprice"=>$coins, "coins" => $coinslist, "coinWallets" => $coinWallets, "rialWallet" => $rialWallet, "transactions" => $transactions));
    }

    public function offerPage(Request $request) {
        $offerablecoins = Wallet::where("type", "coin")->where("user_id", session()->get("user")->id)->get();
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

        $chart_btc = Curl::to("https://api.coincap.io/v2/assets/bitcoin/history")
                ->withData(array('interval' => "d1"))
                ->get();
        $chart_ltc = Curl::to("https://api.coincap.io/v2/assets/litecoin/history")
                ->withData(array('interval' => "d1"))
                ->get();
        $chart_xrp = Curl::to("https://api.coincap.io/v2/assets/ripple/history")
                ->withData(array('interval' => "d1"))
                ->get();
        $bitcoinChart = json_decode($chart_btc)->data;
        $litecoinChart = json_decode($chart_ltc)->data;
        $ripplecoinChart = json_decode($chart_xrp)->data;
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

        return view("dashboard.offers.index", array("user" => session()->get("user"), "offerablecoins" => $offerablecoins, "coins" => $coins, "chart" => $outputChart, "offers" => $offers, "buyoffers" => $buyoffers, "bankaccounts" => $accounts));
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
        $coinhis = Curl::to("https://api.coincap.io/v2/assets/$request->coin/history")
                ->withData(array('interval' => "m1"))
                ->asJson()
                ->get();
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
            $fee = Option::where("key", "sell_fee")->first()->value;
            $coin_type = $request->coin;
            $coin_num = $request->coinـnum;
            $price = $request->price_toman;
            $minbuy = $request->mincoin;
            $wallet = Wallet::where("user_id", $user->id)->where("type", "rial")->first();
            if ($wallet->cashable >= $price) {
                $coin = new CoinOffer();
                $coin->user_id = session()->get("user")->id;
                $coin->amount = $coin_num;
                $coin->coin = $coin_type;
                $coin->price_pre = $price;
                $coin->min_buy = $minbuy;
                $coin->max_buy = $coin_num;
                $coin->type = "buy";
                $wallet->cashable -= $price;
                if ($coin->save() && $wallet->save()) {
                    Activity::addActivity("ایجاد پیشنهاد خرید جدید");
                    return redirect("/dashboard/mywallet");
                } else {
                    return redirect("/dashboard/buyoffer?error=خطا در ذخیره اطلاعات");
                }
            } else {
                return redirect("/dashboard/buyoffer?error=کیف پول ریالی خود را به اندازه مبلغ پیشنهاد شارژ کنید");
            }
        } elseif ($request->type == "sell") {
            $user = session()->get("user");
            $fee = Option::where("key", "sell_fee")->first()->value;
            $coin_type = $request->coin;
            $coin_num = $request->coinـnum;
            $price = $request->price_toman;
            $minbuy = $request->mincoin;
            $wallet = Wallet::where("user_id", $user->id)->where("name", $coin_type)->first();
            if ($wallet->cashable >= $coin_num - ($coin_num * ($fee))) {
                $coin = new CoinOffer();
                $coin->user_id = session()->get("user")->id;
                $coin->amount = $coin_num;
                $coin->coin = $coin_type;
                $coin->price_pre = $price;
                $coin->min_buy = $minbuy;
                $coin->max_buy = $coin_num;
                $coin->type = "sell";
                $wallet->cashable -= $coin_num + ($coin_num * ($fee));

                if ($coin->save() && $wallet->save()) {
                    Activity::addActivity("ایجاد پیشنهاد فروش جدید");
                    return redirect("/dashboard/mywallet");
                } else {
                    return redirect("/dashboard/buyoffer?error=خطا در ذخیره اطلاعات");
                }
            } else {
                return redirect("/dashboard/buyoffer?error=موجودی حساب کافی نیست");
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

        $chart = Curl::to("https://api.coincap.io/v2/assets/bitcoin/history")
                ->withData(array('interval' => "d1"))
                ->get();
        $chart_btc = Curl::to("https://api.coincap.io/v2/assets/bitcoin/history")
                ->withData(array('interval' => "d1"))
                ->get();
        $chart_ltc = Curl::to("https://api.coincap.io/v2/assets/litecoin/history")
                ->withData(array('interval' => "d1"))
                ->get();
        $chart_xrp = Curl::to("https://api.coincap.io/v2/assets/ethereum/history")
                ->withData(array('interval' => "d1"))
                ->get();

        $bitcoinChart = json_decode($chart_btc)->data;
        $litecoinChart = json_decode($chart_ltc)->data;
        $ripplecoinChart = json_decode($chart_xrp)->data;
        $outputChart = array("bitcoin" => "", "litecoin" => "", "ethereum" => "");
        $usdprice = Currency::where("code", "USD")->first()->price;
        $outputChart['bitcoin'] .= "[";
        foreach ($bitcoinChart as $value) {
            $price = $usdprice * $value->priceUsd;
            $outputChart['bitcoin'] .= "$price,";
        }
        $outputChart['bitcoin'] .= "]";

        $outputChart['litecoin'] .= "[";
        foreach ($litecoinChart as $value) {
            $price = $usdprice * $value->priceUsd;
            $outputChart['litecoin'] .= "$price,";
        }
        $outputChart['litecoin'] .= "]";

        $outputChart['ethereum'] .= "[";
        foreach ($ripplecoinChart as $value) {
            $price = $usdprice * $value->priceUsd;
            $outputChart['ethereum'] .= "$price,";
        }
        $outputChart['ethereum'] .= "]";

        $offers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("type", "sell")->where("is_active", true)->where("is_selled", false)->where("user_id", "!=", $user->id)->select('users.name', 'coin_offers.*')->paginate(25);
        $buyoffers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("type", "buy")->where("is_active", true)->where("is_selled", false)->where("user_id", "!=", $user->id)->select('users.name', 'coin_offers.*')->paginate(25);
        return view("dashboard.offers.list", array("user" => session()->get("user"), "coins" => $coins, "chart" => $outputChart, "offers" => $offers, "buyoffers" => $buyoffers));
    }

    public function tickets(Request $request) {
        $user = session()->get("user");
        $tickets = Ticket::where("user_id", $user->id)->get();
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
            foreach ($request->file('files') as $file) {
                $name = $file->getClientOriginalName();
                $path = $file->store('usersfiles');
                $files[] = array("name" => url("/usersfiles/$path"), "name" => $name);
            }
            $ticket->status = "2";
            return $ticket->addMessage($request->text, $files);
        } else {
            return false;
        }
    }

    public function getFile($filename, Request $request) {
        return Storage::download("files/$filename");
    }

    public function newTicket(Request $request) {
        $user = session()->get("user");
        $ticket = new Ticket();
        $ticket->user_id = $user->id;
        $ticket->name = $request->name;
        $ticket->status = "1";
        $ticket->priority = $request->priority;
        $ticket->to = $request->to;
        $ticket->type = 1;
        if ($ticket->save()) {
            $files = array();
            if ($request->has('files')) {
                $request->file('files');
                foreach ($request->file('files') as $file) {
                    $name = $file->getClientOriginalName();
                    $path = $file->store('usersfiles');
                    $files[] = array("link" => url("/$path"), "name" => $name);
                }
            }
            $ticket->addMessage($request->text, $files);
            return redirect("/dashboard/ticket/$ticket->id");
        } else {
            return redirect("/dashboard/tickets/new");
        }
    }

//    public function getCoins(DataTables $dataTables) {
//
//
//        return $dataTables->collection($collection)->editColumn('icon', '<img src="{{ $icon }}" style="max-width: 30px"/>')->addColumn('price_in_toman', function ($coin) {
//                    $usdprice = Currency::where("code", "USD")->first()->price;
//                    $priceInToman = (int) ($coin->priceUsd * $usdprice);
//                    if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
//                        $price = $priceInToman / 1000;
//                        return $price . " هزار تومان";
//                    } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
//                        $price = $priceInToman / 1000000;
//                        return $price . " میلیون تومان";
//                    } elseif ($priceInToman >= 1000000000) {
//                        $price = $priceInToman / 1000000000;
//                        return $price . " میلیارد تومان";
//                    } else {
//                        $price = $priceInToman;
//                        return $price . " تومان";
//                    }
//                })->editColumn('priceUsd', '{{(float)$priceUsd}}$')->editColumn('supply', '{{(int)$supply}}')->rawColumns(['icon'])->toJson();
//    }

    public function getCoinPrice(Request $request) {
        $requestURL = "https://api.coincap.io/v2/assets";
        $response = Curl::to($requestURL)
                ->withData(array('ids' => $request->id))
                ->asJson()
                ->get();
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

    public function marketCap(Request $request) {
        $max = 100;
        $offset = 0;
        $page = 1;
        if ($request->has("page")) {
            $offset = ($request->page - 1) * 10;
            $page = $request->page;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "api.coincap.io/v2/assets?limit=10&offset=$offset",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response);
        $coins = $data->data;
        $output = array();
        foreach ($coins as $coin) {
            $coinhis = Curl::to("https://api.coincap.io/v2/assets/$coin->id/history")
                    ->withData(array('interval' => "d1"))
                    ->asJson()
                    ->get();
            $historydata = "";
            $coinhis = $coinhis->data;
            foreach ($coinhis as $hisdata) {
                $price = $hisdata->priceUsd;
                $power = pow(10, strlen((string) round($price)));
                $historydata .= ($price / $power) . ", ";
            }
            $coin_icon = Common::getIconPath() . "/" . strtolower($coin->symbol) . ".png";
            $client = new Client();
            if (Common::url_exists($coin_icon)) {
                $coin->icon = $coin_icon;
            } else {
                $coin->icon = Common::getLogoPath();
            }
            $coin->history = $historydata;
            $output[] = $coin;
        }
        return view("dashboard.market.coins", array("user" => session()->get("user"), "coins" => $output, "page" => $page));
    }

    public function coinDetail(Request $request) {
        $start = 7300 * 8.64e+7;
        $now = time() * 1000;
        $json = Curl::to("https://api.coincap.io/v2/assets/$request->coin/history")
                ->withData(array("start" => $now - $start, "end" => $now, "interval" => "d1"))
                ->asJson()
                ->get();
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
    
    public function knowledgePage(Request $request) {
        $categories = FaqCategory::all();
        return view("dashboard.knowledge", array("user" => session()->get("user"), "categories" => $categories));
    }


}
