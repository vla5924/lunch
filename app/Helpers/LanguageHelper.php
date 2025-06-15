<?php

namespace App\Helpers;

class LanguageHelper
{
    const SUPPORTED_LOCALES = ['en', 'ru'];

    const DEFAULT_LOCALE = 'ru';

    public static function localeNames()
    {
        $locales = [];
        foreach (self::SUPPORTED_LOCALES as $locale)
            $locales[$locale] = __('common.locale', locale: $locale);
        return $locales;
    }
}
