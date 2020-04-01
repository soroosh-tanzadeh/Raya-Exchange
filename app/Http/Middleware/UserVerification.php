<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\Wallet;

class UserVerification {

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
                    // Check Wallets
                    $user = User::where("phone_number", $user->phone_number)->where('password', $user->password)->first();
                } elseif ($select->files !== null) {
                    return redirect('/dashboard/notverified');
                } else {
                    return redirect('/dashboard/signup?noaccess');
                }
            } else {
                session()->remove("user"); 
                if ($request->isMethod('post')) {
                    return abort(401);
                }
                return redirect('/');
            }
        } else {
            if ($request->isMethod('post')) {
                return abort(401);
            }
            return redirect('/');
        }
        return $next($request);
    }

}
