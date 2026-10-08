<?php

use App\Libraries\AdminPermissions;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class AdminPermissionsTest extends CIUnitTestCase
{
    protected function tearDown(): void
    {
        session()->destroy();
        parent::tearDown();
    }

    public function testOwnerKeepsSensitivePermissions(): void
    {
        session()->set('admin_usertype', 'owner');

        $permissions = new AdminPermissions();

        $this->assertTrue($permissions->can('settings.manage'));
        $this->assertTrue($permissions->can('users.manage'));
        $this->assertTrue($permissions->can('payments.refund'));
        $this->assertTrue($permissions->can('payments.export'));
        $this->assertTrue($permissions->can('activity_logs.view'));
    }

    public function testAdminDoesNotGetOwnerOnlyPaymentActionsByDefault(): void
    {
        session()->set('admin_usertype', 'admin');

        $permissions = new AdminPermissions();

        $this->assertTrue($permissions->can('bookings.manage'));
        $this->assertTrue($permissions->can('payments.view'));
        $this->assertFalse($permissions->can('payments.refund'));
        $this->assertFalse($permissions->can('payments.export'));
        $this->assertFalse($permissions->can('settings.manage'));
        $this->assertFalse($permissions->can('activity_logs.view'));
    }

    public function testStaffIsLimitedByDefault(): void
    {
        session()->set('admin_usertype', 'staff');

        $permissions = new AdminPermissions();

        $this->assertTrue($permissions->can('payments.view'));
        $this->assertFalse($permissions->can('bookings.manage'));
        $this->assertFalse($permissions->can('enquiries.delete'));
        $this->assertFalse($permissions->can('media.manage'));
    }
}
