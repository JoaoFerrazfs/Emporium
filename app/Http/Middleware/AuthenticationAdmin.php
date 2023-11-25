<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthenticationAdmin
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $rule = auth()->user()->rule ?? 0 ;
        if (( $rule == 0 )) {
            return redirect(route('home'));
        }

        return $next($request);
    }
}
