<?php

if (! function_exists('locale_text')) {
    /**
     * Prefer DB/fallback content in Arabic so Filament edits show on the site.
     * In other locales, prefer lang files when present.
     */
    function locale_text(string $key, ?string $fallback = null, array $replace = []): string
    {
        if (is_arabic() && filled($fallback)) {
            return $fallback;
        }

        $translated = __($key, $replace);

        if ($translated === $key) {
            return $fallback ?? $key;
        }

        return $translated;
    }
}

if (! function_exists('setting_text')) {
    /**
     * Site setting with lang fallback (admin Arabic settings win in Arabic locale).
     */
    function setting_text(string $settingKey, string $langKey, ?string $default = null): string
    {
        $value = \App\Models\Setting::get($settingKey);

        if (is_arabic() && filled($value)) {
            return $value;
        }

        $translated = __($langKey);

        if ($translated !== $langKey) {
            return $translated;
        }

        return filled($value) ? $value : ($default ?? $langKey);
    }
}

if (! function_exists('is_arabic')) {
    function is_arabic(): bool
    {
        return app()->getLocale() === 'ar';
    }
}
