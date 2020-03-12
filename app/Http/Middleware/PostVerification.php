<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class PostVerification {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($request->session()->has('user')) {
            $user = session()->get('user');
            $select = User::where("phone_number", $user->phone_number)->where('password', $user->password)->first();
            if ($select !== null) {
                if ($select->verified_at !== null) {
                    session()->put('user', $select);
                } elseif ($select->files !== null) {
                    return response()->json(array("result" => false, "msg" => "حساب شما احراز هویت نشده!"));
                } else {
                    return response()->json(array("result" => false, "msg" => "حساب شما احراز هویت نشده!"));
                }
            } else {
                session()->remove("user");
                return redirect('/');
            }
        } else {
            return redirect('/');
        }
        return $next($request);
    }

}
