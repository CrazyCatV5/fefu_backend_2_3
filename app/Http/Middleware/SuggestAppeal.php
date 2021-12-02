<?php

namespace App\Http\Middleware;

use App\Models\AppealsCount;
use Closure;
use Illuminate\Http\Request;

class SuggestAppeal
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
        $appeals = app(AppealsCount::class);

        if ($request->session()->missing('appeals')) {
            $request->session()->put('appeals', false);
        }

        if ($request->session()->missing('count')) {
            $request->session()->put('count', 0);
            $request->session()->put('time', 0);
        }

        if (!$request->session()->get('appeal') && $request->session()->get('count') < $appeals->total){
            if ($request->session()->get('time') < $appeals->period) {
                $request->session()->increment('time');
            }
            else {
                $request->session()->now('suggestion', true);
                $request->session()->put('thanks', true);
                $request->session()->increment('count');
                $request->session()->put('time', 0);
            }
        }
        return $next($request);
    }
}
