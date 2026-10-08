<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class AdminPermissionRedirectTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    protected function tearDown(): void
    {
        session()->destroy();
        parent::tearDown();
    }

    public function testStaffCannotOpenOwnerOnlyActivityLogs(): void
    {
        $result = $this
            ->withSession($this->adminSession('staff'))
            ->get('admin/activity-logs');

        $result->assertRedirectTo(base_url('admin/dashboard'));
        $result->assertSessionHas('error', 'You do not have permission to view this page.');
    }

    public function testAdminCannotOpenOwnerOnlyActivityLogs(): void
    {
        $result = $this
            ->withSession($this->adminSession('admin'))
            ->get('admin/activity-logs');

        $result->assertRedirectTo(base_url('admin/dashboard'));
        $result->assertSessionHas('error', 'You do not have permission to view this page.');
    }

    public function testOwnerCanOpenActivityLogs(): void
    {
        $result = $this
            ->withSession($this->adminSession('owner'))
            ->get('admin/activity-logs');

        $result->assertOK();
        $result->assertSee('Activity Logs');
    }

    /**
     * @return array<string, mixed>
     */
    private function adminSession(string $role): array
    {
        return [
            'admin_logged_in' => true,
            'admin_name' => 'Permission Test',
            'admin_username' => 'permission.test',
            'admin_usertype' => $role,
        ];
    }
}
