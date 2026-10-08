<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;
use Config\Services;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $permissions = Services::adminPermissions();
        $today = date('Y-m-d');

        $can = [
            'bookingsManage' => $permissions->can('bookings.manage'),
            'paymentsView' => $permissions->can('payments.view'),
            'paymentsExport' => $permissions->can('payments.export'),
            'roomsManage' => $permissions->can('rooms.manage'),
            'eventsManage' => $permissions->can('events.manage'),
            'tridentManage' => $permissions->can('trident.manage'),
            'subscribersView' => $permissions->can('subscribers.view'),
            'mediaManage' => $permissions->can('media.manage'),
            'settingsManage' => $permissions->can('settings.manage'),
            'seoManage' => $permissions->can('seo.manage') && app_setting('system_developer_mode', '0') === '1',
            'usersManage' => $permissions->can('users.manage'),
            'activityLogsView' => $permissions->can('activity_logs.view'),
        ];

        $bookingCounts = [
            'total' => $this->count($db, 'bookings'),
            'today' => $this->count($db, 'bookings', ['DATE(created_at)' => $today]),
            'pending' => $this->count($db, 'bookings', ['status' => 'pending']),
            'confirmed' => $this->count($db, 'bookings', ['status' => 'confirmed']),
            'cancelled' => $this->count($db, 'bookings', ['status' => 'cancelled']),
            'upcoming' => $this->countUpcomingBookings($db, $today),
        ];

        $enquiryCounts = [
            'total' => $this->count($db, 'enquiries'),
            'new' => $this->count($db, 'enquiries', ['status' => 'new']),
            'today' => $this->count($db, 'enquiries', ['DATE(created_at)' => $today]),
        ];

        $eventCounts = [
            'new' => $this->count($db, 'event_enquiries', ['status' => 'new']),
            'today' => $this->count($db, 'event_enquiries', ['DATE(created_at)' => $today]),
            'tridentNew' => $this->count($db, 'trident_enquiries', ['status' => 'new']),
            'tridentToday' => $this->count($db, 'trident_enquiries', ['DATE(created_at)' => $today]),
        ];

        $roomCounts = [
            'total' => $this->count($db, 'rooms'),
            'active' => $this->count($db, 'rooms', ['is_active' => 1]),
            'bookingOpen' => $db->tableExists('rooms') && $this->fieldExists($db, 'rooms', 'booking_open')
                ? $this->count($db, 'rooms', ['booking_open' => 1])
                : 0,
        ];

        $paymentStats = $this->paymentStats($db, $today);
        $subscriberCounts = [
            'total' => $can['subscribersView'] ? $this->count($db, 'subscribers') : 0,
            'today' => $can['subscribersView'] ? $this->count($db, 'subscribers', ['DATE(subscribed_at)' => $today]) : 0,
        ];

        $data = [
            'title' => 'Dashboard',
            'page' => 'dashboard',
            'role' => $permissions->currentRole(),
            'can' => $can,
            'bookingCounts' => $bookingCounts,
            'enquiryCounts' => $enquiryCounts,
            'eventCounts' => $eventCounts,
            'roomCounts' => $roomCounts,
            'paymentStats' => $paymentStats,
            'subscriberCounts' => $subscriberCounts,
            'recentEnquiries' => $this->recentEnquiries($db),
            'recentBookings' => $this->recentBookings($db),
            'recentPayments' => $can['paymentsView'] ? $this->recentPayments($db) : [],
            'upcomingBookings' => $this->upcomingBookings($db, $today),
        ];

        return $this->renderAdmin('admin/dashboard', $data);
    }

    private function renderAdmin(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);
        return view('admin/layouts/app', $data);
    }

    private function count(BaseConnection $db, string $table, array $where = []): int
    {
        if (! $db->tableExists($table)) {
            return 0;
        }

        $builder = $db->table($table);

        foreach ($where as $key => $value) {
            $builder->where($key, $value);
        }

        return $builder->countAllResults();
    }

    private function sum(BaseConnection $db, string $table, string $field, array $where = []): float
    {
        if (! $db->tableExists($table) || ! $this->fieldExists($db, $table, $field)) {
            return 0.0;
        }

        $builder = $db->table($table)->selectSum($field, 'total');

        foreach ($where as $key => $value) {
            $builder->where($key, $value);
        }

        return (float) (($builder->get()->getRowArray()['total'] ?? 0) ?: 0);
    }

    private function fieldExists(BaseConnection $db, string $table, string $field): bool
    {
        return $db->tableExists($table) && $db->fieldExists($field, $table);
    }

    private function countUpcomingBookings(BaseConnection $db, string $today): int
    {
        if (! $db->tableExists('bookings')) {
            return 0;
        }

        return $db->table('bookings')
            ->where('checkin >=', $today)
            ->whereIn('status', ['pending', 'confirmed'])
            ->countAllResults();
    }

    private function paymentStats(BaseConnection $db, string $today): array
    {
        return [
            'total' => $this->count($db, 'payment_transactions'),
            'paid' => $this->count($db, 'payment_transactions', ['status' => 'paid']),
            'pending' => $this->count($db, 'payment_transactions', ['status' => 'pending']),
            'failed' => $this->count($db, 'payment_transactions', ['status' => 'failed']),
            'todayPaid' => $this->count($db, 'payment_transactions', ['status' => 'paid', 'DATE(paid_at)' => $today]),
            'paidAmount' => $this->sum($db, 'payment_transactions', 'amount', ['status' => 'paid']),
            'todayPaidAmount' => $this->sum($db, 'payment_transactions', 'amount', ['status' => 'paid', 'DATE(paid_at)' => $today]),
        ];
    }

    private function recentEnquiries(BaseConnection $db): array
    {
        if (! $db->tableExists('enquiries')) {
            return [];
        }

        return $db->table('enquiries')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
    }

    private function recentBookings(BaseConnection $db): array
    {
        if (! $db->tableExists('bookings')) {
            return [];
        }

        return $db->table('bookings')
            ->orderBy('created_at', 'DESC')
            ->limit(6)
            ->get()
            ->getResultArray();
    }

    private function upcomingBookings(BaseConnection $db, string $today): array
    {
        if (! $db->tableExists('bookings')) {
            return [];
        }

        return $db->table('bookings')
            ->where('checkin >=', $today)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('checkin', 'ASC')
            ->limit(5)
            ->get()
            ->getResultArray();
    }

    private function recentPayments(BaseConnection $db): array
    {
        if (! $db->tableExists('payment_transactions')) {
            return [];
        }

        return $db->table('payment_transactions pt')
            ->select('pt.id, pt.gateway, pt.amount, pt.currency, pt.status, pt.created_at, pt.paid_at, COALESCE(b.booking_code, ep.payment_code) as booking_code, COALESCE(b.name, ep.customer_name) as name, COALESCE(b.room_type, ep.event_type) as room_type, pt.payment_for')
            ->join('bookings b', 'b.id = pt.booking_id', 'left')
            ->join('event_payments ep', 'ep.id = pt.event_payment_id', 'left')
            ->orderBy('pt.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
    }
}
