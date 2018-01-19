<?php

namespace App\Http\Middleware;

use Closure;
use App\Common\Utility;
use Illuminate\Support\Facades\Input;

class securityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      //  Utility::stripXSS(); //prevent xss , should be called before server side validation so as validation is done on safe data


        return $next($request);
    }


}
