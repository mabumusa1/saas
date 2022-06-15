<?php

namespace App\Http\Middleware;

use App\Facades\AccountResolver;
use Closure;
use Illuminate\Http\Request;

class SetAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->route()->hasParameter('account')) {
            AccountResolver::setAccount($request->route()->parameter('account'));
        }

        return $next($request);
    }
}
