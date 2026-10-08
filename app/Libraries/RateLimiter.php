<?php

namespace App\Libraries;

use CodeIgniter\Database\BaseConnection;

class RateLimiter
{
    public function __construct(private readonly ?BaseConnection $db = null)
    {
    }

    public function isLocked(string $scope, string $identifier): bool
    {
        $row = $this->row($scope, $identifier);

        if (! $row || empty($row['locked_until'])) {
            return false;
        }

        return strtotime((string) $row['locked_until']) > time();
    }

    public function lockedMessage(string $scope, string $identifier, string $fallback = 'Too many attempts. Please try again later.'): string
    {
        $row = $this->row($scope, $identifier);

        if (! $row || empty($row['locked_until'])) {
            return $fallback;
        }

        $seconds = max(1, strtotime((string) $row['locked_until']) - time());
        $minutes = max(1, (int) ceil($seconds / 60));

        return $fallback . ' Try again in about ' . $minutes . ' minute' . ($minutes === 1 ? '' : 's') . '.';
    }

    public function hit(string $scope, string $identifier, int $maxAttempts, int $lockMinutes): void
    {
        if (! $this->ready()) {
            return;
        }

        $maxAttempts = max(1, $maxAttempts);
        $lockMinutes = max(1, $lockMinutes);
        $now = date('Y-m-d H:i:s');
        $row = $this->row($scope, $identifier);

        if (! $row) {
            $this->db()->table('rate_limit_attempts')->insert([
                'scope' => $scope,
                'identifier' => $identifier,
                'attempts' => 1,
                'locked_until' => $maxAttempts <= 1 ? date('Y-m-d H:i:s', time() + ($lockMinutes * 60)) : null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            return;
        }

        $expiredLock = ! empty($row['locked_until']) && strtotime((string) $row['locked_until']) <= time();
        $attempts = ($expiredLock ? 0 : (int) ($row['attempts'] ?? 0)) + 1;
        $update = [
            'attempts' => $attempts,
            'locked_until' => $attempts >= $maxAttempts ? date('Y-m-d H:i:s', time() + ($lockMinutes * 60)) : null,
            'updated_at' => $now,
        ];

        $this->db()->table('rate_limit_attempts')
            ->where('scope', $scope)
            ->where('identifier', $identifier)
            ->update($update);
    }

    public function clear(string $scope, string $identifier): void
    {
        if (! $this->ready()) {
            return;
        }

        $this->db()->table('rate_limit_attempts')
            ->where('scope', $scope)
            ->where('identifier', $identifier)
            ->delete();
    }

    private function row(string $scope, string $identifier): ?array
    {
        if (! $this->ready()) {
            return null;
        }

        return $this->db()->table('rate_limit_attempts')
            ->where('scope', $scope)
            ->where('identifier', $identifier)
            ->get()
            ->getRowArray();
    }

    private function ready(): bool
    {
        return $this->db()->tableExists('rate_limit_attempts');
    }

    private function db(): BaseConnection
    {
        return $this->db ?? \Config\Database::connect();
    }
}
