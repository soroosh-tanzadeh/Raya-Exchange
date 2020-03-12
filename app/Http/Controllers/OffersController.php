<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Morilog\Jalali\Jalalian;
use Ixudra\Curl\Facades\Curl;
use App\Currency;
use App\CoinOffer;

class OffersController extends Controller {

    public function getBuyOffers(DataTables $datatable, Request $request) {
        $user = session()->get("user");
        $offers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("is_active", true)->where("type", "buy")->where("is_selled", false)->where("user_id", "!=", $user->id)->select('users.name', 'coin_offers.*');
        if (!$request->has("list")) {
            $offers = $offers->limit(10);
        }
        if ($request->has("coin") && $request->input("coin") !== "more") {
            return Datatables::eloquent($offers->where("coin", $request->coin)->where("is_active", true))->addColumn('action', function ($offer) {
                        return '<a data-toggle="tooltip" title="" data-original-title="فروش"  href="/dashboard/offerpage?offer=' . $offer->id . '" class="text-success font-18"><i class="ft-thumbs-up"></i></a>';
                    })->editColumn('created_at', function($offer) {
                        return Jalalian::forge($offer->created_at)->ago();
                    })->editColumn('price_pre', function($offer) {
                        $priceInToman = $offer->price_pre;
                        $price_in_toman = "";
                        if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                            $price = $priceInToman / 1000;
                            $price_in_toman = $price . " هزار تومان";
                        } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                            $price = $priceInToman / 1000000;
                            $price_in_toman = $price . " میلیون تومان";
                        } elseif ($priceInToman >= 1000000000) {
                            $price = $priceInToman / 1000000000;
                            $price_in_toman = $price . " میلیارد تومان";
                        } else {
                            $price = $priceInToman;
                            $price_in_toman = $price . " تومان";
                        }
                        return $price_in_toman;
                    })->editColumn('amount', function($offer) {
                        return number_format($offer->amount, 8);
                    })->editColumn('min_buy', function($offer) {
                        return number_format($offer->min_buy, 8);
                    })->editColumn('coin', function($offer) {
                        $requestURL = "https://api.coincap.io/v2/assets";
                        $response = Curl::to($requestURL)
                                ->get();
                        $coins_raw = json_decode($response)->data;
                        $coins = array();
                        $usdprice = Currency::where("code", "USD")->first()->price;
                        foreach ($coins_raw as $coin) {
                            $coins[$coin->id] = $coin;
                        }
                        return ($coins[$offer->coin]->symbol) . ' <img src="/assets/icons/' . strtolower($coins[$offer->coin]->symbol) . '.png" style="max-width: 30px;"/>';
                    })->rawColumns(['coin', 'action'])->make(true);
        } else {
            $offers = $offers->whereRaw("coin != 'bitcoin'")->whereRaw("coin != 'etheruem'")->whereRaw(" coin != 'teather'");
            return Datatables::eloquent($offers)->addColumn('action', function ($offer) {
                        return '<a data-toggle="tooltip" title="" data-original-title="خرید" href="/dashboard/offerpage?offer=' . $offer->id . '" class="text-success font-18"><i class="ft-thumbs-up"></i></a>';
                    })->editColumn('created_at', function($offer) {
                        return Jalalian::forge($offer->created_at)->ago();
                    })->editColumn('price_pre', function($offer) {
                        $priceInToman = $offer->price_pre;
                        $price_in_toman = "";
                        if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                            $price = $priceInToman / 1000;
                            $price_in_toman = $price . " هزار تومان";
                        } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                            $price = $priceInToman / 1000000;
                            $price_in_toman = $price . " میلیون تومان";
                        } elseif ($priceInToman >= 1000000000) {
                            $price = $priceInToman / 1000000000;
                            $price_in_toman = $price . " میلیارد تومان";
                        } else {
                            $price = $priceInToman;
                            $price_in_toman = $price . " تومان";
                        }
                        return $price_in_toman;
                    })->editColumn('amount', function($offer) {
                        return number_format($offer->amount, 8);
                    })->editColumn('min_buy', function($offer) {
                        return number_format($offer->min_buy, 8);
                    })->editColumn('coin', function($offer) {
                        $requestURL = "https://api.coincap.io/v2/assets";
                        $response = Curl::to($requestURL)
                                ->get();
                        $coins_raw = json_decode($response)->data;
                        $coins = array();
                        $usdprice = Currency::where("code", "USD")->first()->price;
                        foreach ($coins_raw as $coin) {
                            $coins[$coin->id] = $coin;
                        }
                        return ($coins[$offer->coin]->symbol) . ' <img src="/assets/icons/' . strtolower($coins[$offer->coin]->symbol) . '.png" style="max-width: 30px;"/>';
                    })->rawColumns(['coin', 'action'])->make(true);
        }
    }

    public function getSellOffers(Request $request) {
        $user = session()->get("user");
        $offers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("is_active", true)->where("type", "buy")->where("is_selled", false)->where("user_id", "!=", $user->id)->select('users.name', 'coin_offers.*');
        if (!$request->has("list")) {
            $offers = $offers->limit(10);
        }
        if ($request->has("coin") && $request->input("coin") !== "more") {
            return Datatables::eloquent($offers->where("coin", $request->coin))->addColumn('action', function ($offer) {
                        return '<a data-toggle="tooltip" title="" data-original-title="خرید" href="/dashboard/offerpage?offer=' . $offer->id . '" class="text-success font-18"><i class="ft-shopping-cart"></i></a>';
                    })->editColumn('created_at', function($offer) {
                        return Jalalian::forge($offer->created_at)->ago();
                    })->editColumn('price_pre', function($offer) {
                        $priceInToman = $offer->price_pre;
                        $price_in_toman = "";
                        if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                            $price = $priceInToman / 1000;
                            $price_in_toman = $price . " هزار تومان";
                        } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                            $price = $priceInToman / 1000000;
                            $price_in_toman = $price . " میلیون تومان";
                        } elseif ($priceInToman >= 1000000000) {
                            $price = $priceInToman / 1000000000;
                            $price_in_toman = $price . " میلیارد تومان";
                        } else {
                            $price = $priceInToman;
                            $price_in_toman = $price . " تومان";
                        }
                        return $price_in_toman;
                    })->editColumn('amount', function($offer) {
                        return number_format($offer->amount, 8);
                    })->editColumn('min_buy', function($offer) {
                        return number_format($offer->min_buy, 8);
                    })->editColumn('coin', function($offer) {
                        $requestURL = "https://api.coincap.io/v2/assets";
                        $response = Curl::to($requestURL)
                                ->get();
                        $coins_raw = json_decode($response)->data;
                        $coins = array();
                        $usdprice = Currency::where("code", "USD")->first()->price;
                        foreach ($coins_raw as $coin) {
                            $coins[$coin->id] = $coin;
                        }
                        return ($coins[$offer->coin]->symbol) . ' <img src="/assets/icons/' . strtolower($coins[$offer->coin]->symbol) . '.png" style="max-width: 30px;"/>';
                    })->rawColumns(['coin', 'action'])->make(true);
        } else {
            $offers = $offers->whereRaw("coin != 'bitcoin'")->whereRaw("coin != 'etheruem'")->whereRaw(" coin != 'teather' ");
            return Datatables::eloquent($offers)->addColumn('action', function ($offer) {
                        return '<a data-toggle="tooltip" title="" data-original-title="خرید" href="/dashboard/offerpage?offer=' . $offer->id . '" class="text-success font-18"><i class="ft-shopping-cart"></i></a>';
                    })->editColumn('created_at', function($offer) {
                        return Jalalian::forge($offer->created_at)->ago();
                    })->editColumn('price_pre', function($offer) {
                        $priceInToman = $offer->price_pre;
                        $price_in_toman = "";
                        if (($priceInToman >= 1000) & ($priceInToman < 1000000)) {
                            $price = $priceInToman / 1000;
                            $price_in_toman = $price . " هزار تومان";
                        } elseif ($priceInToman >= 1000000 & ($priceInToman < 1000000000)) {
                            $price = $priceInToman / 1000000;
                            $price_in_toman = $price . " میلیون تومان";
                        } elseif ($priceInToman >= 1000000000) {
                            $price = $priceInToman / 1000000000;
                            $price_in_toman = $price . " میلیارد تومان";
                        } else {
                            $price = $priceInToman;
                            $price_in_toman = $price . " تومان";
                        }
                        return $price_in_toman;
                    })->editColumn('amount', function($offer) {
                        return number_format($offer->amount, 8);
                    })->editColumn('min_buy', function($offer) {
                        return number_format($offer->min_buy, 8);
                    })->editColumn('coin', function($offer) {
                        $requestURL = "https://api.coincap.io/v2/assets";
                        $response = Curl::to($requestURL)
                                ->get();
                        $coins_raw = json_decode($response)->data;
                        $coins = array();
                        $usdprice = Currency::where("code", "USD")->first()->price;
                        foreach ($coins_raw as $coin) {
                            $coins[$coin->id] = $coin;
                        }
                        return ($coins[$offer->coin]->symbol) . ' <img src="/assets/icons/' . strtolower($coins[$offer->coin]->symbol) . '.png" style="max-width: 30px;"/>';
                    })->rawColumns(['coin', 'action'])->make(true);
        }
    }

}
