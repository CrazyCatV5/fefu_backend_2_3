<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;

class RedirectFromOldSlug
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

        $url = parse_url($request->url());
        $redirect = Redirect::where('old_slug', $url)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->first();
        $newSlug = null;

        while ($redirect !== null)
        {
            $newSlug = $redirect->new_slug;
            $redirect = Redirect::query()
                ->where('old_slug', $newSlug)
                ->where('created_at', '>', $redirect->created_at)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->first();
        }
        if ($newSlug!== null) {
            return redirect($newSlug);
        }
        return $next($request);
    }
}
