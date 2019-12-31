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

    public function buyOfferPage(Request $request) {
        
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
