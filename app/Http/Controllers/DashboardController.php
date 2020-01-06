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

class DashboardController extends Controller {

    public function index() {
        $requestURL = "https://api.coincap.io/v2/assets";
        $response = Curl::to($requestURL)
                ->withData(array('ids' => "bitcoin,ethereum,litecoin,ripple,monero"))
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
            $coins[] = $coin;
        }

        $chart = Curl::to("https://api.coincap.io/v2/assets/bitcoin/history")
                ->withData(array('interval' => "d1"))
                ->get();
        $chart = json_decode($chart)->data;
        $outputChart = "";
        foreach ($chart as $value) {
            $outputChart .= "[$value->time,$value->priceUsd],";
        }
        return view("dashboard.index", array("user" => session()->get("user"), "coins" => $coins, "chart" => $outputChart));
    }

    public function walletPage(Request $request) {
        $user = session()->get("user");
        $rialWallet = Wallet::where("user_id", $user->id)->where("type", "rial")->first();
        $coinWallets_data = Wallet::where("user_id", $user->id)->where("type", "coin")->get();
        $coinWallets = array();
        foreach ($coinWallets_data as $wallet) {
            $coinWallets[$wallet->type_name] = $wallet;
        }
        $transactions = Transaction::where("user_id", $user->id)->limit(10)->get();
        return view("dashboard.wallet.index", array("user" => $user, "coinWallets" => $coinWallets, "rialWallet" => $rialWallet, "transactions" => $transactions));
    }

    public function offerPage(Request $request) {
        $requestURL = "https://api.coincap.io/v2/assets";
        $response = Curl::to($requestURL)
                ->withData(array('ids' => "bitcoin,ethereum,litecoin,ripple,monero"))
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
            $coins[] = $coin;
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
            $outputChart['bitcoin'] .= "[$value->time,$price],";
        }
        foreach ($litecoinChart as $value) {
            $price = $usdprice * $value->priceUsd;
            $outputChart['litecoin'] .= "[$value->time,$price],";
        }
        foreach ($ripplecoinChart as $value) {
            $price = $usdprice * $value->priceUsd;
            $outputChart['ripple'] .= "[$value->time,$price],";
        }
        return view("dashboard.offers.index", array("user" => session()->get("user"), "coins" => $coins, "chart" => $outputChart));
    }

    public function newoffer(Request $request) {
        $user = session()->get("user");
        $fee = Option::where("key", "sell_fee")->first()->value;
        $coin_type = $request->coin;
        $coin_num = $request->coinـnum;
        $wallet = Wallet::where("user_id", $user->id)->where("name", $coin_type)->first();
        if ($wallet->credit >= $coin_num - ($coin_num * ($fee))) {
            $coin = new CoinOffer();
            $coin->user_id = session()->get("user")->id;
            $coin->amount = $coin_num;
            $coin->coin = $coin_type;
            $wallet->cashable -= $coin_num + ($coin_num * ($fee));
            if ($coin->save() && $wallet->save())
                return redirect("/dashboard/mywallet");
            else
                return redirect("/dashboard/buyoffer?error=خطا در ذخیره اطلاعات");
        } else {
            return redirect("/dashboard/buyoffer?error=موجودی حساب کافی نیست");
        }
    }
    
    public function offersList(Request $request) {
        $user = session()->get("user");
        $requestURL = "https://api.coincap.io/v2/assets";
        $response = Curl::to($requestURL)
                ->withData(array('ids' => "bitcoin,ethereum,litecoin,ripple,monero"))
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
            $outputChart['bitcoin'] .= "[$value->time,$price],";
        }
        foreach ($litecoinChart as $value) {
            $price = $usdprice * $value->priceUsd;
            $outputChart['litecoin'] .= "[$value->time,$price],";
        }
        foreach ($ripplecoinChart as $value) {
            $price = $usdprice * $value->priceUsd;
            $outputChart['ripple'] .= "[$value->time,$price],";
        }

        $offers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("is_active", true)->where("is_selled", false)->where("user_id" , "!=" ,$user->id)->select('users.name', 'coin_offers.*')->paginate(25);

        return view("dashboard.offers.list", array("user" => session()->get("user"), "coins" => $coins, "chart" => $outputChart, "offers" => $offers));
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
        return Storage::download("usersfiles/$filename", $request->name);
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
            $request->file('files');
            foreach ($request->file('files') as $file) {
                $name = $file->getClientOriginalName();
                $path = $file->store('usersfiles');
                $files[] = array("link" => url("/$path"), "name" => $name);
            }
            return response()->json(array("result" => $ticket->addMessage($request->text, $files), "files" => $files));
        } else {
            return response()->json(array("result" => false));
        }
    }

    public function getCoins(DataTables $dataTables) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "api.coincap.io/v2/assets",
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
            $coin_icon = Common::getIconPath() . "/" . strtolower($coin->symbol) . ".png";
            $client = new Client();
            if (Common::url_exists($coin_icon)) {
                $coin->icon = $coin_icon;
            } else {
                $coin->icon = Common::getLogoPath();
            }
            $output[] = $coin;
        }
        $collection = collect($output);

        return $dataTables->collection($collection)->editColumn('icon', '<img src="{{ $icon }}" style="max-width: 30px"/>')->addColumn('price_in_toman', function ($coin) {
                    $usdprice = Currency::where("code", "USD")->first()->price;
                    $priceInToman = (int) ($coin->priceUsd * $usdprice);
                    if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                        $price = $priceInToman / 1000;
                        return $price . " هزار تومان";
                    } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                        $price = $priceInToman / 1000000;
                        return $price . " میلیون تومان";
                    } elseif ($priceInToman >= 1000000000) {
                        $price = $priceInToman / 1000000000;
                        return $price . " میلیارد تومان";
                    } else {
                        $price = $priceInToman;
                        return $price . " تومان";
                    }
                })->editColumn('priceUsd', '{{(float)$priceUsd}}$')->editColumn('supply', '{{(int)$supply}}')->rawColumns(['icon'])->toJson();
    }

    public function getCoinPrice($coin_id) {
        $requestURL = "https://api.coincap.io/v2/assets?ids=$coin_id";
        $response = Curl::to($requestURL)
                ->withData(array('ids' => $coin_id))
                ->get();
    }

    public function marketCap(Request $request) {
        return view("dashboard.market.coins", array("user" => session()->get("user")));
    }

}
