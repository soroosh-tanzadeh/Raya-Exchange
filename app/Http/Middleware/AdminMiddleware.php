<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class AdminMiddleware {

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
            $select = User::where("phone_number", $user->phone_number)->where('password', $user->password)->where("is_admin", true)->first();
            if ($select !== null) {
                session()->put('user', $select);
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
