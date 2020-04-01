<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Route;

class AdminMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($request->session()->has('user_admin')) {
            $user = session()->get('user_admin');
         //   dd(session()->all());
            $select = User::where("phone_number", $user->phone_number)
                            ->where('password', $user->password)
                            ->where("is_admin", true)
                            ->join("permissions", "users.permissions", "=", "permissions.id")
                            ->select(array("users.*", "permissions.permissions as permissions_json"))->first();
            if ($select !== null) {
                session()->put('user_admin', $select);
                $permissions = json_decode($select->permissions_json);
                if (in_array("/" . Route::current()->uri, $permissions->routes)) {
                    return $next($request);
                } else {
                    return redirect("/nopermission");
                }
            } else {
                // dd($user);
                session()->remove("user_admin");
                return redirect('/ERROR');
            }
        } else {
            return redirect('/');
        }
        return $next($request);
    }

}
