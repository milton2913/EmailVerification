<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CheckProfileContentIsUpdate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if (empty(auth()->user()->mobile) or (auth()->user()->mobile == null)) {

                if (!$request->routeIs('profile.edit')) {
                    if (!$request->isMethod('post')) {
                        return redirect()
                            ->route('profile.edit')
                            ->with('message', trans('global.updateYourProfile'));
                    }
                }
            }
        }
        return $next($request);
    }
}
