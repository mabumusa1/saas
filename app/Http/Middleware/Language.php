<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Language
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (\Session::has('local')) {
            \App::setLocale(\Session::get('local'));
        }

        return $next($request);
    }
}
