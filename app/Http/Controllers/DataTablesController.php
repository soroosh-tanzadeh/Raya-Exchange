<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Transaction;
use App\Checkout;
use Morilog\Jalali\Jalalian;
use App\Currency;
use App\CoinOffer;
use App\AffilateTransaction;
use App\AffilateCheckout;

class DataTablesController extends Controller {

    public function transactions(DataTables $datatable) {
        $transactions = Transaction::where("user_id", session()->get("user")->id)->get();
        return DataTables::of($transactions)
                        ->editColumn("created_at", function ($deposit) {
                            return Jalalian::forge($deposit->created_at)->format("y/m/d h:m");
                        })->editColumn("status", function ($deposit) {
                            if ($deposit->status === "موفق") {
                                return '<text class="text-success">موفق</text>';
                            } else {
                                return '<text class="text-danger">ناموفق</text>';
                            }
                        })->rawColumns(["status"])
                        ->make(true);
    }

    public function coinpayments(DataTables $datatable) {
        $checkouts = Checkout::query()->join("wallets", "wallets.id", "=", "checkouts.wallet_id")->select(array("checkouts.*", "wallets.type_name as coin"))->where("checkouts.user_id", session()->get("user")->id)->get();
        return DataTables::of($checkouts)
                        ->editColumn("created_at", function ($checkout) {
                            return Jalalian::forge($checkout->created_at)->format("y/m/d h:m");
                        })->editColumn("is_payed", function ($checkout) {
                            if ($checkout->is_payed) {
                                return '<text class="text-success">پرداخت شده</text>';
                            } else {
                                return '<text class="text-warning">پرداخت نشده</text>';
                            }
                        })->rawColumns(["is_payed"])
                        ->make(true);
    }

    public function deposits(DataTables $datatable) {
        $transactions = Order::query()->where("user_id", session()->get("user")->id)->get();
        return DataTables::of($transactions)
                        ->editColumn("created_at", function ($deposit) {
                            return Jalalian::forge($deposit->created_at)->format("y/m/d h:m");
                        })->editColumn("confirmed", function ($deposit) {
                            if ($deposit->confirmed) {
                                return '<text class="text-success">نهایی شده</text>';
                            } else {
                                return '<text class="text-warning">نهایی نشده</text>';
                            }
                        })->rawColumns(["confirmed"])
                        ->make(true);
    }

    public function rialpayments(DataTables $datatable) {
        $deposits = Transaction::where("user_id", session()->get("user")->id)->where("type", "شارژ حساب")->get();
        return DataTables::of($deposits)
                        ->editColumn("created_at", function ($deposit) {
                            return Jalalian::forge($checkout->created_at)->format("y/m/d h:m");
                        })->editColumn("is_payed", function ($deposit) {
                            if ($deposit->is_payed) {
                                return '<text class="text-success">پرداخت شده</text>';
                            } else {
                                return '<text class="text-warning">پرداخت نشده</text>';
                            }
                        })->rawColumns(["is_payed"])
                        ->make(true);
    }

    public function rialdeposits(DataTables $datatable) {
        $checkouts = Checkout::query()->join("bank_accounts", "bank_accounts.id", "=", "checkouts.bankaccount_id")->select(array("checkouts.*", "bank_accounts.IBAN", "bank_accounts.account_number", "bank_accounts.card_number"))->where("checkouts.user_id", session()->get("user")->id)->get();
        return DataTables::of($checkouts)
                        ->editColumn("created_at", function ($checkout) {
                            return Jalalian::forge($checkout->created_at)->format("y/m/d h:m");
                        })->editColumn("is_payed", function ($checkout) {
                            if ($checkout->is_payed) {
                                return '<text class="text-success">پرداخت شده</text>';
                            } else {
                                return '<text class="text-warning">پرداخت نشده</text>';
                            }
                        })->rawColumns(["is_payed"])
                        ->make(true);
    }

    public function myoffers(DataTables $datatable) {
        $offers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("user_id", session()->get('user')->id)->select('users.name', 'coin_offers.*');

        return DataTables::of($offers)
                        ->editColumn("coin", function ($offer) {
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
                            return $offer->coin . " <img src='/assets/icons/" . strtolower($coins[$offer->coin]->symbol) . ".png' style='max-width: 30px;'/>";
                        })->addColumn("price_in_toman", function($offer) {
                            $priceInToman = ($offer->price_pre * $offer->amount) / $offer->max_buy;
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
                        })->editColumn("created_at", function ($offer) {
                            return Jalalian::forge($offer->created_at)->format("y/m/d h:m");
                        })->editColumn("is_payed", function ($offer) {
                            if ($offer->type === "sell") {
                                return " فروش";
                            } else {
                                return "خرید";
                            }
                        })->editColumn("is_selled", function() {
                            if ($offer->is_selled) {
                                return " فروخته شده";
                            } else {
                                return " در انتظار خریدار";
                            }
                        })->editColumn("actions", function() {
                            return '<input type="button" class="btn btn-danger canceloffer" value="لغو پیشنهاد" />';
                        })->rawColumns(["coin", "actions"])
                        ->make(true);
    }

    public function affilatetransactions(DataTables $datatable) {
        $transactions = AffilateTransaction::query()->where("user_id", session()->get("user")->id);
        return DataTables::of($transactions)
                        ->editColumn("created_at", function ($transaction) {
                            return Jalalian::forge($transaction->created_at)->format("y/m/d h:m");
                        })
                        ->editColumn("amount", function ($transaction) {
                            return number_format($transaction->amount) . " تومان";
                        })->make(true);
    }

    public function affilatecheckouts(DataTables $datatable) {
        $checkouts = AffilateCheckout::where("user_id", session()->get("user")->id)->latest()->get();
        return DataTables::of($checkouts)
                        ->editColumn("created_at", function ($checkout) {
                            return Jalalian::forge($checkout->created_at)->format("y/m/d h:m");
                        })
                        ->editColumn("amount", function ($checkout) {
                            return number_format($checkout->amount) . " تومان";
                        })
                        ->editColumn("is_payed", function ($checkout) {
                            if ($checkout->checkout) {
                                return '<text class="text-success">پرداخت شده</text>';
                            } else {
                                return '<text class="text-warning">پرداخت نشده</text>';
                            }
                        })->make(true);
    }

}
