<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\BankAccount;
use App\Ticket;
use App\Transaction;
use App\Checkout;
use App\Order;
use App\CoinOffer;
use App\Wallet;
use App\AffilateWallet;
use App\Question;
use App\FaqCategory;
use App\Option;
use Yajra\DataTables\Facades\DataTables;
use Morilog\Jalali\Jalalian;
use Carbon\Carbon;

class AdminController extends Controller {

    public function index() {
        $users = User::where("is_admin", "!=", true)->get();
        $selloffersall = CoinOffer::where("type", "sell")->get();
        $buyoffersall = CoinOffer::where("type", "buy")->get();
        $selloffers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->select('users.name', 'coin_offers.*')->latest()->limit(10)->get();
        $buyoffers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("type", "buy")->select('users.name', 'coin_offers.*')->latest()->limit(10)->get();
        return view("admin.index", array("users" => $users, "selloffersall" => $selloffersall, "buyoffersall" => $buyoffersall, "user" => session()->get("user"), "selloffers" => $selloffers, "buyoffers" => $buyoffers));
    }

    public function newQuestion(Request $request) {
        $qeustiontext = $request->question;
        $answer = $request->answer;
        $category = $request->category;
        $question = new Question();
        $question->question = $qeustiontext;
        $question->answer = $answer;
        $question->category = $category;
        return response()->json(array("result" => $question->save(), "msg" => "با موفقیت ایجاد شد."));
    }

    public function faqPage(Request $request) {
        $categories = FaqCategory::all();
        return view("dashboard.faq", array("user" => session()->get("user"), "categories" => $categories));
    }

    public function verifyUser(Request $request) {
        $user_id = $request->id;
        $user = User::find($user_id);
        $user->verified_at = time();
        $wallets = array("btc" => "bitcoin", "eth" => "ethereum", "ltc" => "litecoin", "xrp" => "ripple", "Tether USD (Omni Layer)" => "usdt", "Bitcoin Cash" => "bch");
        foreach ($wallets as $key => $value) {
            $wallet = new Wallet();
            $wallet->type = "coin";
            $wallet->type_name = $key;
            $wallet->name = $value;
            $wallet->cashable = 0;
            $wallet->credit = 0;
            $wallet->user_id = $user_id;
            $wallet->save();
        }

        $wallet = new Wallet();
        $wallet->type = "rial";
        $wallet->type_name = "Rial";
        $wallet->name = "";
        $wallet->cashable = 0;
        $wallet->credit = 0;
        $wallet->user_id = $user_id;
        $wallet->save();


        $Awallet = new AffilateWallet();
        $Awallet->user_id = $user_id;
        $Awallet->credit = 0;
        $Awallet->save();

        return response()->json(array("result" => $user->save()));
    }

    public function comfirmPayment(Request $request) {
        $pay = Checkout::where("id", $request->id)->first();
        $pay->is_payed = true;
        return response()->json(array("result" => $pay->save()));
    }

    public function comfirmCoinReceive(Request $request) {
        $pay = Order::where("id", $request->id)->first();
        $pay->confirmed = true;
        return response()->json(array("result" => $pay->save()));
    }

    public function tickets(Request $request) {
        $tickets = Ticket::query();
        if ($request->has("type")) {
            $tickets = $tickets->where("type", $request->type);
        }
        return view("admin.tickets.tickets", array("user" => session()->get("user"), "tickets" => $tickets->latest()->paginate(10)));
    }

    public function showTicket($ticket_id) {
        $tickets = Ticket::where("id", $ticket_id)->first();
        return view("admin.tickets.ticketchat", array("user" => session()->get("user"), "ticket" => $tickets));
    }

    public function showNewTicket(Request $request) {
        if ($request->has("user")) {
            $toUser = $request->user;
            if (User::where("id", $toUser) !== null) {
                return view("admin.tickets.newticket", array("touser" => $toUser, "user" => session()->get("user")));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function closeTicket(Request $request) {
        $ticket = Ticket::where("id", $request->ticket)->first();
        $ticket->type = 3;
        $ticket->status = "بسته شده";
        $ticket->save();
        return redirect("/admin/tickets");
    }

    public function showSettings() {
        $options = Option::all();
        return view("admin.settings", array("options" => $options, "user" => session()->get("user")));
    }

    public function saveOptions(Request $request) {
        $keys = $request->input("key");
        foreach ($keys as $key => $value) {
            $option = Option::where("key", $key)->first();
            $option->value = $value;
            $option->save();
        }
        return redirect("/admin/settings");
    }

    public function sendMessage($ticket_id, Request $request) {
        $ticket = Ticket::where("id", $ticket_id)->first();
        if ($ticket !== null) {
            $files = array();
            if ($request->has($files)) {
                if (is_array($request->file('files'))) {
                    foreach ($request->file('files') as $file) {
                        $name = $file->getClientOriginalName();
                        $path = $file->store('usersfiles');
                        $files[] = array("link" => url("/$path"), "name" => $name);
                    }
                }
            }
            $ticket->type = 2;
            $ticket->status = "پاسخ پشتیبانی";
            $ticket->save();
            $ticket->addAdminMessage($request->text, $files);
            return redirect("/admin/ticket/$ticket_id");
        } else {
            return redirect("/admin/ticket/$ticket_id");
        }
    }

    public function newTicket(Request $request) {
        $ticket = new Ticket();
        $ticket->user_id = -1;
        $ticket->name = $request->name;
        $ticket->status = "2";
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

    public function userProfile($user_id) {
        $user = User::where("id", $user_id)->first();
        return view("admin.users.profile", array("user" => session()->get("user"), "profile" => $user));
    }

    public function coinpayments(Request $request) {
        $coincheckouts = Checkout::query()->where("token", "!=", null)->latest()->paginate(25);
        return view("admin.users", array("checkouts" => $checkouts, "user" => session()->get("user")));
    }

    public function rialpayments(Request $request) {
        $rialcheckouts = Checkout::query()->join("bank_accounts", "bank_accounts.id", "=", "checkouts.bankaccount_id")->select(array("checkouts.*", "bank_accounts.IBAN", "bank_accounts.account_number", "bank_accounts.card_number"))->latest()->paginate(25);
        $deposits = Transaction::query()->latest()->paginate(25);
        return view("admin.transactions.rial", array("checkouts" => $rialcheckouts, "deposits" => $deposits, "user" => session()->get("user")));
    }

    public function verifyBankAccount(Request $request) {
        $bankaccount = BankAccount::where("id", $request->id)->first();
        $bankaccount->is_active = true;
        if ($bankaccount->save()) {
            return response()->json(array("result" => true, "msg" => "با موفقیت تایید شد."));
        } else {
            return response()->json(array("result" => false, "msg" => "خطا در ذخیره اطلاعات"));
        }
    }

    public function bankAccountsPage(Request $request) {
        $accounts = BankAccount::query()->latest()->paginate(25);
        return view("admin.bankaccounts", array("bankaccounts" => $accounts, "user" => session()->get("user")));
    }

    public function users(Request $request) {
        $users = User::query()->latest()->paginate(25);
        return view("admin.users.index", array("users" => $users, "user" => session()->get("user")));
    }

    public function transactions(Request $request) {
        return view("admin.transactions", array("user" => session()->get("user")));
    }

    public function getUsers() {
        $users = User::latest();

        return DataTables::of($users)
                        ->editColumn("name", function($user) {
                            return "<a href='/admin/users/$user->id'> <b>$user->name</b> </a>";
                        })
                        ->addColumn("status", function($user) {
                            if ($user->verified_at != null) {
                                return '<text class="text-success">تایید شده</text>';
                            } else {
                                return '<text class="text-warning">تایید نشده</text>';
                            }
                        })
                        ->addColumn("signup_date", function ($user) {
                            return Jalalian::forge($user->created_at)->ago();
                        })
                        ->rawColumns(["name", "status", "created_at"])
                        ->make(true);
    }

    public function getTransactions(Request $request) {

        $deposits = Transaction::query()->join("users", "transactions.user_id", "=", "users.id")->select(array("transactions.*", "users.name as user_name", "users.phone_number"));

        if ($request->has("date")) {
            if ($request->date === "d") {
                $deposits = $deposits->whereDate('transactions.created_at', date("Y-m-d"));
            } elseif ($request->date === "w") {
                $deposits = $deposits->whereBetween('transactions.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($request->date === "m") {
                $deposits = $deposits->whereMonth('transactions.created_at', Carbon::now()->month);
            } elseif ($request->date === "y") {
                $deposits = $deposits->whereYear('transactions.created_at', Carbon::now()->year);
            }
        }

        return DataTables::of($deposits)
                        ->editColumn("created_at", function ($deposit) {
                            return Jalalian::forge($deposit->created_at)->ago();
                        })->editColumn("status", function ($deposit) {
                            if ($deposit->status === "موفق") {
                                return '<text class="text-success">موفق</text>';
                            } else {
                                return '<text class="text-danger">ناموفق</text>';
                            }
                        })->rawColumns(["status"])
                        ->make(true);
    }

    public function getBankAccounts(DataTables $data) {
        $bankAccounts = BankAccount::query()->latest();

        return DataTables::of($bankAccounts)
                        ->editColumn("created_at", function ($bankAccount) {
                            return Jalalian::forge($bankAccount->created_at)->ago();
                        })
                        ->editColumn("is_active", function ($bankAccount) {
                            if ($bankAccount->is_active) {
                                return '<text class="text-success">تایید شده</text>';
                            } else {
                                return "<input type=\"submit\" value=\"تایید پرداخت\" class=\"btn btn-success\" onclick=\"comfirmBank(this)\" data-bankaccount=\"$bankAccount->id\" />";
                            }
                        })
                        ->rawColumns(["is_active"])
                        ->make(true);
    }

}
