<?php

namespace App\Libraries;

use CodeIgniter\Database\BaseConnection;

class AdminPermissions
{
    private const PERMISSIONS = [
        'bookings.manage' => ['label' => 'Bookings', 'group' => 'Operations', 'description' => 'View bookings and update booking status.'],
        'payments.view' => ['label' => 'Payments View', 'group' => 'Payments', 'description' => 'View payment manager and transaction status.'],
        'payments.recheck' => ['label' => 'Payment Recheck', 'group' => 'Payments', 'description' => 'Recheck payment/refund status with the gateway.'],
        'payments.export' => ['label' => 'Payment Export', 'group' => 'Payments', 'description' => 'Export payment CSV reports.'],
        'payments.refund' => ['label' => 'Refunds', 'group' => 'Payments', 'description' => 'Request and approve gateway refunds.'],
        'enquiries.delete' => ['label' => 'Delete Enquiries', 'group' => 'Operations', 'description' => 'Delete contact, event, and Trident enquiry records.'],
        'subscribers.view' => ['label' => 'Subscribers', 'group' => 'Marketing', 'description' => 'View subscriber email list.'],
        'rooms.manage' => ['label' => 'Rooms', 'group' => 'Content', 'description' => 'Create, edit, and import rooms. Delete remains owner-only.'],
        'events.manage' => ['label' => 'Events', 'group' => 'Content', 'description' => 'Manage event enquiries, services, packages, and page content.'],
        'trident.manage' => ['label' => 'Trident', 'group' => 'Content', 'description' => 'Manage Trident enquiries and event content.'],
        'media.manage' => ['label' => 'Media/Gallery', 'group' => 'Content', 'description' => 'Upload and edit media and gallery images. Delete remains owner-only.'],
        'pages.manage' => ['label' => 'Pages', 'group' => 'Developer', 'description' => 'Edit public page content blocks.'],
        'seo.manage' => ['label' => 'SEO Manager', 'group' => 'Developer', 'description' => 'Manage SEO metadata, robots, and sitemap settings.'],
        'settings.manage' => ['label' => 'Settings', 'group' => 'Owner', 'description' => 'Manage hotel, email, system, and payment gateway settings.'],
        'users.manage' => ['label' => 'Users', 'group' => 'Owner', 'description' => 'Create users and update roles/passwords.'],
        'activity_logs.view' => ['label' => 'Activity Logs', 'group' => 'Owner', 'description' => 'View audit trail of admin actions.'],
    ];

    private const ROLE_PERMISSIONS = [
        'owner' => [
            'users.manage',
            'payments.view',
            'payments.recheck',
            'payments.refund',
            'payments.export',
            'bookings.manage',
            'activity_logs.view',
            'settings.manage',
            'seo.manage',
            'pages.manage',
            'subscribers.view',
            'media.manage',
            'rooms.manage',
            'events.manage',
            'trident.manage',
            'enquiries.delete',
        ],
        'admin' => [
            'payments.view',
            'payments.recheck',
            'bookings.manage',
            'subscribers.view',
            'media.manage',
            'rooms.manage',
            'events.manage',
            'trident.manage',
        ],
        'staff' => [
            'payments.view',
        ],
    ];

    public function __construct(private readonly ?BaseConnection $db = null)
    {
    }

    public function roles(): array
    {
        return [
            'owner' => 'Owner',
            'admin' => 'Admin',
            'staff' => 'Staff',
        ];
    }

    public function permissions(): array
    {
        return self::PERMISSIONS;
    }

    public function manageableRoles(): array
    {
        return [
            'admin' => 'Admin',
            'staff' => 'Staff',
        ];
    }

    public function permissionsForRole(string $role): array
    {
        if (! array_key_exists($role, self::ROLE_PERMISSIONS)) {
            $role = 'staff';
        }

        if ($role === 'owner') {
            return array_values(array_unique(self::ROLE_PERMISSIONS['owner']));
        }

        $permissions = self::ROLE_PERMISSIONS[$role] ?? [];
        $overrides = $this->overridesForRole($role);

        foreach ($overrides as $permission => $allowed) {
            if (! array_key_exists($permission, self::PERMISSIONS)) {
                continue;
            }

            if ($allowed && ! in_array($permission, $permissions, true)) {
                $permissions[] = $permission;
            }

            if (! $allowed) {
                $permissions = array_values(array_diff($permissions, [$permission]));
            }
        }

        return array_values(array_unique($permissions));
    }

    public function setPermissionsForRole(string $role, array $permissions): void
    {
        if (! array_key_exists($role, $this->manageableRoles())) {
            return;
        }

        $allowed = array_values(array_filter(
            array_intersect(array_keys(self::PERMISSIONS), $permissions),
            static fn (string $permission): bool => ! str_contains($permission, '.delete')
        ));
        $default = self::ROLE_PERMISSIONS[$role] ?? [];
        $now = date('Y-m-d H:i:s');
        $db = $this->db();

        if (! $db->tableExists('role_permission_overrides')) {
            return;
        }

        foreach (self::PERMISSIONS as $permission => $_meta) {
            $defaultAllowed = in_array($permission, $default, true);
            $newAllowed = in_array($permission, $allowed, true);

            $db->table('role_permission_overrides')
                ->where('role', $role)
                ->where('permission', $permission)
                ->delete();

            if ($defaultAllowed === $newAllowed) {
                continue;
            }

            $db->table('role_permission_overrides')->insert([
                'role' => $role,
                'permission' => $permission,
                'is_allowed' => $newAllowed ? 1 : 0,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function currentRole(): string
    {
        $role = '';
        $adminId = session()->get('admin_id');

        if ($adminId) {
            $user = $this->db()->table('users')
                ->select('usertype')
                ->where('id', (int) $adminId)
                ->get()
                ->getRowArray();
            $role = (string) ($user['usertype'] ?? '');
        }

        if ($role === '') {
            $role = (string) session()->get('admin_usertype');
        }

        return array_key_exists($role, self::ROLE_PERMISSIONS) ? $role : 'staff';
    }

    public function isOwner(): bool
    {
        return $this->currentRole() === 'owner';
    }

    public function canDeleteData(): bool
    {
        return $this->isOwner();
    }

    public function can(string $permission): bool
    {
        if (str_contains($permission, '.delete') && ! $this->isOwner()) {
            return false;
        }

        return in_array($permission, $this->permissionsForRole($this->currentRole()), true);
    }

    private function overridesForRole(string $role): array
    {
        $db = $this->db();

        if (! $db->tableExists('role_permission_overrides')) {
            return [];
        }

        $rows = $db->table('role_permission_overrides')
            ->where('role', $role)
            ->get()
            ->getResultArray();

        $overrides = [];

        foreach ($rows as $row) {
            $overrides[(string) ($row['permission'] ?? '')] = ! empty($row['is_allowed']);
        }

        return $overrides;
    }

    private function db(): BaseConnection
    {
        return $this->db ?? \Config\Database::connect();
    }
}
