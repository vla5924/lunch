<?php

namespace App\Http\Middleware;

use App\Helpers\LanguageHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SwitchLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = Auth::user()->locale;
        if (!\in_array($locale, LanguageHelper::SUPPORTED_LOCALES))
            $locale = LanguageHelper::DEFAULT_LOCALE;
        App::setLocale($locale);

        return $next($request);
    }
}
