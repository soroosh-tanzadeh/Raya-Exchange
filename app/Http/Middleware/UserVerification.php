<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

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
                } elseif ($select->name !== null) {
                    return redirect('/dashboard/notverified');
                } else {
                    return redirect('/dashboard/signup');
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
