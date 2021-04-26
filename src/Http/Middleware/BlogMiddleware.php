<?php

namespace Marshmallow\Blogs\Http\Middleware;

use Closure;

class BlogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        dd('Check if it is published');
        return $next($request);
    }
}
