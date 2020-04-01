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
use Illuminate\Support\Facades\Crypt;
use App\Alert;
use App\SMS;

class AdminController extends Controller {

    public function index() {
        $users = User::where("is_admin", "!=", true)->get();
        $selloffersall = CoinOffer::where("type", "sell")->get();
        $buyoffersall = CoinOffer::where("type", "buy")->get();
        $selloffers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->select('users.name', 'coin_offers.*')->latest()->limit(10)->get();
        $buyoffers = CoinOffer::join("users", "users.id", "=", "coin_offers.user_id")->where("type", "buy")->select('users.name', 'coin_offers.*')->latest()->limit(10)->get();
        return view("admin.index", array("users" => $users, "selloffersall" => $selloffersall, "buyoffersall" => $buyoffersall, "user" => session()->get("user_admin"), "selloffers" => $selloffers, "buyoffers" => $buyoffers));
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
        return view("dashboard.faq", array("user" => session()->get("user_admin"), "categories" => $categories));
    }

    public function verifyUser(Request $request) {
        $user_id = $request->id;
        $user = User::find($user_id);
        $user->verified_at = time();

        UserController::checkWallets($user);

        $Awallet = new AffilateWallet();
        $Awallet->user_id = $user_id;
        $Awallet->credit = 0;
        $Awallet->save();

        $sms = new SMS($user->phone_number);
        $sms->signupSuccess($user->name);

        $ticket = new Ticket();
        $ticket->user_id = -1;
        $ticket->name = "به RayaEx خوش آمدید";
        $ticket->priority = 1;
        $ticket->to = $user->id;
        $ticket->type = 2;
        $ticket->status = "سیستم";
        $ticket->save();
        $ticket->addAdminMessage("کاربر گرامی $user->name ضمن عرض خوش‌آمد مدارک شما در سامانه RayaEx تایید شد.", array());

        return response()->json(array("result" => $user->save()));
    }

    public function offers(Request $request) {
        if ($request->has("buyers")) {
            return view("admin.transactions.offers", array("user" => session()->get("user_admin"), "buyers" => true));
        }
        return view("admin.transactions.offers", array("user" => session()->get("user_admin")));
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
        $user = session()->get("user_admin");
        $permissions = json_decode($user->permissions_json)->tickets;

        $tickets = $tickets->where("to", $permissions[0]);

        foreach ($permissions as $permission) {
            $tickets = $tickets->orWhere("to", $permission);
        }


        return view("admin.tickets.tickets", array("user" => session()->get("user_admin"), "tickets" => $tickets->latest()->paginate(10)));
    }

    public function showTicket($ticket_id) {
        $tickets = Ticket::where("id", $ticket_id)->first();
        return view("admin.tickets.ticketchat", array("user" => session()->get("user_admin"), "ticket" => $tickets));
    }

    public function showNewTicket(Request $request) {
        if ($request->has("user")) {
            $toUser = $request->user;
            if (User::where("id", $toUser) !== null) {
                return view("admin.tickets.newticket", array("touser" => $toUser, "user" => session()->get("user_admin")));
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
        return view("admin.settings", array("options" => $options, "user" => session()->get("user_admin")));
    }

    public function saveOptions(Request $request) {
        $keys = $request->input("key");
        $result = true;
        foreach ($keys as $key => $value) {
            $result = Option::setOption($key, $value);
        }
        return response()->json(array("result" => $result));
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
            $ticket->type = 2;
            $ticket->status = "پاسخ پشتیبانی";
            $ticket->save();
            $ticket->addAdminMessage($request->text, $files);
            $sms = new SMS($user->phone_number);
            $sms->answerTicekt($this->name, $this->id);
            $ticket->save();
            return response()->json(array("result" => true, "redirect" => "/admin/ticket/$ticket->id"));
        } else {
            return abort(404);
        }
    }

    public function newTicket(Request $request) {
        $ticket = new Ticket();
        $ticket->user_id = $request->user_id;
        $ticket->name = $request->name;
        $ticket->status = "پیام پشتیبانی";
        $ticket->priority = $request->priority;
        $ticket->to = $request->to;
        $ticket->type = 2;
        if ($ticket->save()) {
            $files = array();
            $request->file('files');
            if ($request->has('files')) {
                foreach ($request->file('files') as $file) {
                    $name = $file->getClientOriginalName();
                    $path = $file->store('usersfiles');
                    $files[] = array("link" => url("/$path"), "name" => $name);
                }
            }
            $ticket->addAdminMessage($request->text, $files);
            return redirect("/admin/ticket/" . $ticket->id);
        } else {
            return redirect("/tickets/new");
        }
    }

    public function userProfile($user_id) {
        $user = User::where("id", $user_id)->first();
        return view("admin.users.profile", array("user" => session()->get("user_admin"), "profile" => $user));
    }

    public function coinpayments(Request $request) {
        $coincheckouts = Checkout::query()->where("token", "!=", null)->latest()->paginate(25);
        return view("admin.transactions.crypto", array("checkouts" => $coincheckouts, "user" => session()->get("user_admin")));
    }

    public function rialpayments(Request $request) {
        $rialcheckouts = Checkout::query()->join("bank_accounts", "bank_accounts.id", "=", "checkouts.bankaccount_id")->select(array("checkouts.*", "bank_accounts.IBAN", "bank_accounts.account_number", "bank_accounts.card_number"))->latest()->paginate(25);
        $deposits = Transaction::query()->latest()->paginate(25);
        return view("admin.transactions.rial", array("checkouts" => $rialcheckouts, "deposits" => $deposits, "user" => session()->get("user_admin")));
    }

    public function getrialpayments(DataTables $datatable) {
        $deposits = Transaction::where("coin", "تومان")->where("type", "شارژ حساب")->join("users", "users.id", "=", "transactions.user_id")->select(array("transactions.*", "users.name as user_name"))->get();
        return DataTables::of($deposits)
                        ->editColumn("created_at", function ($deposit) {
                            return Jalalian::forge($deposit->created_at)->format("y/m/d h:m");
                        })->editColumn("is_payed", function ($deposit) {
                            if ($deposit->is_payed) {
                                return '<text class="text-success">پرداخت شده</text>';
                            } else {
                                return '<text class="text-warning">پرداخت نشده</text>';
                            }
                        })->rawColumns(["is_payed"])
                        ->make(true);
    }

    public function getcoindeposits(DataTables $datatable) {
        $checkouts = Checkout::query()->join("wallets", "wallets.id", "=", "checkouts.wallet_id")->select(array("checkouts.*", "wallets.type_name as coin", "users.name as user_name"))->join("users", "users.id", "=", "checkouts.user_id")->where("wallets.type_name", "!=", "Rial")->get();
        return DataTables::of($checkouts)
                        ->editColumn("created_at", function ($checkout) {
                            return Jalalian::forge($checkout->created_at)->format("y/m/d h:m");
                        })->editColumn("is_payed", function ($checkout) {
                            if ($checkout->is_payed) {
                                return '<text class="text-success">پرداخت شده</text>';
                            } else {
                                return '<input type="submit" value="تایید پرداخت" class="btn btn-success" onclick="comfirmPay(this)" data-checkout="' . $checkout->id . '" />';
                            }
                        })->rawColumns(["is_payed"])
                        ->make(true);
    }

    public function getrialdeposits(DataTables $datatable) {
        $checkouts = Checkout::query()->join("bank_accounts", "bank_accounts.id", "=", "checkouts.bankaccount_id")->join("users", "users.id", "=", "checkouts.user_id")->select(array("checkouts.*", "users.name as user_name", "bank_accounts.owner as bank_owner", "bank_accounts.IBAN", "bank_accounts.account_number", "bank_accounts.card_number"))->get();
        return DataTables::of($checkouts)
                        ->editColumn("created_at", function ($checkout) {
                            return Jalalian::forge($checkout->created_at)->format("y/m/d h:m");
                        })->editColumn("is_payed", function ($checkout) {
                            if ($checkout->is_payed) {
                                return '<text class="text-success">پرداخت شده</text>';
                            } else {
                                
                            }
                        })->addColumn("actions", function($checkout) {
                            $actions = "<div class='btn-group justify-content-center align-items-center'><a href='/admin/tickets/new?user=$checkout->user_id' data-toggle='tooltip' title='ارسال تیکت به کاربر' class='btn rounded-0 btn-outline-dark btn-sm'><i class='ft-inbox'></i></a></div>";
                              if (!$checkout->is_payed) {
                                return '<button class="btn btn-sm btn-outline-success" onclick="comfirmPay(this)" data-toggle="tooltip" title="تایید پرداخت" data-checkout="' . $checkout->id . '" ><i class="ft-check></i></button>';
                            }
                            $actions .= "</div>";
                            return $actions;
                        })->rawColumns(["is_payed", "actions"])
                        ->make(true);
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
        return view("admin.bankaccounts", array("bankaccounts" => $accounts, "user" => session()->get("user_admin")));
    }

    public function users(Request $request) {
        $users = User::query()->where("is_admin", false)->latest()->paginate(25);
        return view("admin.users.index", array("users" => $users, "user" => session()->get("user_admin")));
    }

    public function transactions(Request $request) {
        return view("admin.transactions", array("user" => session()->get("user_admin")));
    }

    public function getUsers() {
        $users = User::query()->where("is_admin", false);

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
                        })->addColumn("actions", function ($user) {
                            $actions = "<div class='input-group justify-content-center align-items-center'><a class='btn btn-sm rounded-0 btn-outline-warning' href='/admin/users/$user->id' data-toggle='tooltip' title='ویرایش'><i class='ft-edit'></i></a>";

                            if ($user->active) {
                                $actions .= "<button class='btn btn-sm rounded-0 btn-outline-danger' onclick='deactiveUser(" . $user->id . ",this)' data-toggle='tooltip' title='غیرفعالسازی'><i class='ft-slash'></i></button>";
                            } else {
                                $actions .= "<button class='btn btn-sm rounded-0 btn-outline-success' onclick='activeUser(" . $user->id . ",this)' data-toggle='tooltip' title='فعالسازی'><i class='ft-check'></i></button>";
                            }
                            $actions .= "</div>";
                            return $actions;
                        })->rawColumns(["name", "status", "created_at", "actions"])
                        ->make(true);
    }

    public function activeUser(Request $request) {
        $user = User::find($request->user_id);
        $user->active = true;
        $user->save();
    }

    public function deactiveUser(Request $request) {
        $user = User::find($request->user_id);
        $user->active = false;
        $user->save();
    }

    public function activeOffer(Request $request) {
        $user = User::find($request->offer_id);
        $user->suspended = false;
        $user->save();
    }

    public function deactiveOffer(Request $request) {
        $user = User::find($request->offer_id);
        $user->suspended = true;
        $user->save();
    }

    public function editUser(Request $request) {
        $name = $request->name;
        $address = $request->address;
        $province = $request->province;
        $city = $request->city;
        $postalcode = $request->postalcode;
        $nationalcode = $request->nationalcode;
        $telephone = $request->telephone;
        $email = $request->email;

        $user = User::where("id", $request->user_id)->first();
        $user->name = $name;
        $user->address = $address;
        $user->province = $province;
        $user->city = $city;
        $user->telephone = $telephone;
        $user->nationalcode = $nationalcode;
        $user->postalcode = $postalcode;
        $user->is_admin = false;
        $user->permissions = null;
        $user->email = $email;

        if ($user->save()) {
            return response()->json(array("result" => true, "msg" => "با موفقیت ثبت شد"));
        } else {
            return response()->json(array("result" => false, "msg" => "خطا در ثبت اطلاعات"));
        }
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
                            return Jalalian::forge($deposit->created_at)->format("y/m/d H:i:s");
                        })->editColumn("status", function ($deposit) {
                            if ($deposit->status === "موفق") {
                                return '<text class="text-success">موفق</text>';
                            } else {
                                return '<text class="text-danger">ناموفق</text>';
                            }
                        })->addColumn("actions", function($deposit) {
                            $actions = "<div class='btn-group justify-content-center align-items-center'><a href='/admin/tickets/new?user=$deposit->user_id' data-toggle='tooltip' title='ارسال تیکت به کاربر' class='btn rounded-0 btn-outline-dark btn-sm'><i class='ft-inbox'></i></a></div>";
                            return $actions;
                        })->rawColumns(["status", "actions"])
                        ->make(true);
    }

    public function getBankAccounts(DataTables $data) {
        $bankAccounts = BankAccount::query()->join("users", "bank_accounts.user_id", "=", "users.id")->select(array("users.name as user_name", "bank_accounts.*"))->latest();
        return DataTables::of($bankAccounts)
                        ->editColumn("created_at", function ($bankAccount) {
                            return Jalalian::forge($bankAccount->created_at)->ago();
                        })
                        ->editColumn("is_active", function ($bankAccount) {
                            if ($bankAccount->is_active) {
                                return '<text class="text-success">تایید شده</text>';
                            } else {
                                return '<text class="text-warning">در انتظار تایید</text>';
                            }
                        })
                        ->addColumn("actions", function ($bankaccount) {
                            $actions = "<div class='btn-group justify-content-center align-items-center'><a href='/admin/tickets/new?user=$bankaccount->user_id' data-toggle='tooltip' title='ارسال تیکت به کاربر' class='btn rounded-0 btn-outline-dark btn-sm'><i class='ft-inbox'></i></a>";
                            if (!$bankaccount->is_active) {
                                $actions .= "<button class='btn rounded-0 btn-outline-success btn-sm' onclick=\"comfirmBank(this)\" data-bankaccount=\"$bankaccount->id\"  data-toggle='tooltip' title='تایید حساب' /><i class='ft-check'></i></button>";
                            }
                            $actions .= "</div>";
                            return $actions;
                        })->rawColumns(["is_active", "actions"])
                        ->make(true);
    }

    public function adminsPage(Request $request) {
        $admins = User::where("is_admin", true)
                ->join("permissions", "users.permissions", "=", "permissions.id")
                ->select(array("users.*", "permissions.name as permissions_name"))
                ->where("users.id", "!=", session()->get("user_admin")->id)
                ->get();
        return view("admin.admins", array("user" => session()->get("user_admin"), "admins" => $admins));
    }

    public function newAdmin(Request $request) {
        $name = $request->name;
        $phone = $request->phone;
        $permission = $request->permissions;
        $password = Crypt::encryptString($request->password);

        $admin = new User();
        $admin->phone_number = $phone;
        $admin->name = $name;
        $admin->permissions = $permission;
        $admin->password = $password;
        $admin->is_admin = true;
        return response()->json(array("result" => $admin->save(), "msg" => "با موفقیت ایجاد شد."));
    }

    public function deleteAdmin(Request $request) {
        $user = User::findOrFail($request->id);
        return response()->json(array("result" => $user->delete(), "msg" => "با موفقیت حذف شد"));
    }

    public function newAlert(Request $request) {
        $alerts = Alert::all();
        foreach ($alerts as $alert) {
            $alert->active = false;
            $alert->save();
        }
        $alert = new Alert();
        $alert->active = true;
        $alert->text = $request->text;
        $alert->type = $request->type;
        if ($request->hasFile('icon')) {
            $alert->icon = url($request->icon->store('images'));
        }
        return response()->json(array("result" => $alert->save(), "msg" => "با موفقیت ارسال شد"));
    }

    public function deactiveAlert(Request $request) {
        $alert = Alert::findOrFail($request->id);
        $alert->active = false;
        return response()->json(array("result" => $alert->save(), "msg" => "با موفقیت غیرفعال شد"));
    }

    public function alertsPage(Request $request) {
        $alerts = Alert::query()->latest()->paginate(20);
        return view("admin.alerts", array("user" => session()->get("user_admin"), "alerts" => $alerts));
    }

    public function getTickets(Request $request) {
        $tickets = Ticket::query();
        if ($request->has("type")) {
            $tickets = $tickets->where("type", $request->type);
        }
        $user = session()->get("user_admin");
        $permissions = json_decode($user->permissions_json)->tickets;

        $tickets = $tickets->where("to", $permissions[0]);

        foreach ($permissions as $permission) {
            $tickets = $tickets->orWhere("to", $permission);
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
                            return "<a href=\"/admin/ticket/$ticket->id\" class=\"link text-black\">$ticket->name</a>";
                        })
                        ->rawColumns(["type", "created_at", "name"])
                        ->make(true);
    }

    public function editAdmin(Request $request) {
        $user = User::findOrFail($request->user_id);
        $user->name = $request->name;
        $user->password = Crypt::encryptString($request->password);
        $user->save();
        return response()->json(array("result" => true, "msg" => "با موفقیت انجام شد."));
    }

    public function changePass(Request $request) {
        $user = session()->get("user_admin");
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
        return view("dashboard.pass", array("user" => session()->get("user_admin")));
    }

}
