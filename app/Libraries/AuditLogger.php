<?php

namespace App\Libraries;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\HTTP\IncomingRequest;
use Throwable;

class AuditLogger
{
    public function __construct(private readonly ?BaseConnection $db = null)
    {
    }

    public function log(string $action, string $entityType, string|int|null $entityId, string $summary, array $changes = []): void
    {
        $db = $this->db();

        if (! $db->tableExists('admin_activity_logs')) {
            return;
        }

        try {
            $request = service('request');
            $session = session();

            $db->table('admin_activity_logs')->insert([
                'admin_id' => $session->get('admin_id') ? (int) $session->get('admin_id') : null,
                'admin_name' => $session->get('admin_name') ?: $session->get('admin_username'),
                'action' => $action,
                'entity_type' => $entityType,
                'entity_id' => $entityId !== null ? (string) $entityId : null,
                'summary' => $summary,
                'changes' => $changes !== [] ? json_encode($changes, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null,
                'ip_address' => $request instanceof IncomingRequest ? $request->getIPAddress() : null,
                'user_agent' => $request instanceof IncomingRequest ? substr((string) $request->getUserAgent(), 0, 255) : null,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (Throwable $e) {
            log_message('error', 'Audit log write failed: {message}', ['message' => $e->getMessage()]);
        }
    }

    private function db(): BaseConnection
    {
        return $this->db ?? \Config\Database::connect();
    }
}
