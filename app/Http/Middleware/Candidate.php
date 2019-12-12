<?php

namespace App\Http\Middleware;

use Closure;

class Candidate
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
        abort_if(!$request->user()->isCandidate(), 404);
        
        return $next($request);
    }
}
