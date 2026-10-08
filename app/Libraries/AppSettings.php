<?php

namespace App\Libraries;

use Config\Services;
use Throwable;

class AppSettings
{
    private const ENCRYPTED_PREFIX = 'enc:v1:';

    private const PROTECTED_KEYS = [
        'cashfree_secret_key',
        'cashfree_webhook_secret',
        'razorpay_key_secret',
        'razorpay_webhook_secret',
    ];

    private ?array $settings = null;

    public function all(): array
    {
        if ($this->settings !== null) {
            return $this->settings;
        }

        try {
            $db = \Config\Database::connect();

            if (! method_exists($db, 'tableExists') || ! $db->tableExists('settings')) {
                return $this->settings = [];
            }

            $rows = $db->table('settings')->get()->getResultArray();
            $settings = array_column($rows, 'value', 'key');

            foreach ($settings as $key => $value) {
                if ($this->isProtectedKey((string) $key)) {
                    $settings[$key] = $this->decryptValue((string) $value);
                }
            }

            return $this->settings = $settings;
        } catch (Throwable) {
            return $this->settings = [];
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->all();

        if (! array_key_exists($key, $settings)) {
            return $default;
        }

        $value = $settings[$key];

        return $value === null || $value === '' ? $default : $value;
    }

    public function isProtectedKey(string $key): bool
    {
        return in_array($key, self::PROTECTED_KEYS, true);
    }

    public function isEncryptedValue(string $value): bool
    {
        return str_starts_with($value, self::ENCRYPTED_PREFIX);
    }

    public function encryptValue(string $value): string
    {
        if ($value === '' || $this->isEncryptedValue($value)) {
            return $value;
        }

        $encrypted = Services::encrypter()->encrypt($value);

        return self::ENCRYPTED_PREFIX . base64_encode($encrypted);
    }

    public function decryptValue(string $value): string
    {
        if ($value === '' || ! $this->isEncryptedValue($value)) {
            return $value;
        }

        try {
            $payload = base64_decode(substr($value, strlen(self::ENCRYPTED_PREFIX)), true);

            if ($payload === false) {
                return '';
            }

            return (string) Services::encrypter()->decrypt($payload);
        } catch (Throwable) {
            return '';
        }
    }
}
