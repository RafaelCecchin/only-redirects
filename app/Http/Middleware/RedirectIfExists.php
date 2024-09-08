<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Redirect;

class RedirectIfExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $scheme = $request->getScheme();
        $host = $request->getHost();
        $path = $request->path() != '/' ? '/' . $request->path() : '/';
        $inputUri = $scheme . '://' . $host . $path;

        $redirect = Redirect::where('input_uri', $inputUri)->where('active', true)->first();

        if ($redirect) {
            return redirect($redirect->output_uri);
        }

        return $next($request);
    }
}
