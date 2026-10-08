<?php

use Config\Services;

if (! function_exists('app_settings')) {
    function app_settings(): array
    {
        return Services::appSettings()->all();
    }
}

if (! function_exists('app_setting')) {
    function app_setting(string $key, mixed $default = null): mixed
    {
        return Services::appSettings()->get($key, $default);
    }
}

if (! function_exists('media_active_path')) {
    function media_active_path(?string $path): string
    {
        $value = trim((string) $path);

        if ($value === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $value)) {
            return $value;
        }

        return ltrim($value, '/');
    }
}

if (! function_exists('media_url')) {
    function media_url(?string $path, string $default = ''): string
    {
        $value = media_active_path($path);

        if ($value === '') {
            return $default;
        }

        if (preg_match('#^https?://#i', $value)) {
            return $value;
        }

        return base_url($value);
    }
}
