<?php

if (! function_exists('locale_text')) {
    /**
     * Translate a key, falling back to the provided default when missing.
     */
    function locale_text(string $key, ?string $fallback = null, array $replace = []): string
    {
        $translated = __($key, $replace);

        if ($translated === $key) {
            return $fallback ?? $key;
        }

        return $translated;
    }
}

if (! function_exists('is_arabic')) {
    function is_arabic(): bool
    {
        return app()->getLocale() === 'ar';
    }
}
