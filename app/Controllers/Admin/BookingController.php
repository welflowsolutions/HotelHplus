<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class BookingController extends BaseController
{
    private function render(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);
        return view('admin/layouts/app', $data);
    }

    public function index(): string
    {
        $db     = \Config\Database::connect();
        $status = $this->request->getGet('status') ?? 'all';
        $builder = $db->table('bookings')->orderBy('created_at', 'DESC');
        if ($status !== 'all') $builder->where('status', $status);

        return $this->render('admin/bookings/index', [
            'title'    => 'Bookings',
            'page'     => 'bookings',
            'bookings' => $builder->get()->getResultArray(),
            'status'   => $status,
            'counts'   => [
                'all'       => $db->table('bookings')->countAll(),
                'pending'   => $db->table('bookings')->where('status','pending')->countAll(),
                'confirmed' => $db->table('bookings')->where('status','confirmed')->countAll(),
                'cancelled' => $db->table('bookings')->where('status','cancelled')->countAll(),
            ],
        ]);
    }

    public function calendar()
    {
        if (! service('adminPermissions')->can('bookings.manage')) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'You do not have permission to view bookings.');
        }

        $db = \Config\Database::connect();
        $month = trim((string) ($this->request->getGet('month') ?? date('Y-m')));

        if (! preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = date('Y-m');
        }

        $start = $month . '-01';
        $end = date('Y-m-t', strtotime($start));
        $bookings = $db->table('bookings b')
            ->select('b.*, r.available_units')
            ->join('rooms r', 'r.id = b.room_id', 'left')
            ->where('checkin <=', $end)
            ->where('checkout >=', $start)
            ->whereIn('b.status', ['pending', 'confirmed'])
            ->orderBy('b.checkin', 'ASC')
            ->get()
            ->getResultArray();

        return $this->render('admin/bookings/calendar', [
            'title' => 'Booking Calendar',
            'page' => 'bookings',
            'month' => $month,
            'calendarDays' => $this->calendarDays($month, $bookings),
            'prevMonth' => date('Y-m', strtotime($start . ' -1 month')),
            'nextMonth' => date('Y-m', strtotime($start . ' +1 month')),
        ]);
    }

    public function create()
    {
        if (! service('adminPermissions')->can('bookings.manage')) {
            return redirect()->to(base_url('admin/bookings'))->with('error', 'You do not have permission to create bookings.');
        }

        return $this->render('admin/bookings/form', [
            'title' => 'Create Booking',
            'page' => 'bookings',
            'rooms' => $this->activeRooms(),
        ]);
    }

    public function store()
    {
        if (! service('adminPermissions')->can('bookings.manage')) {
            return redirect()->to(base_url('admin/bookings'))->with('error', 'You do not have permission to create bookings.');
        }

        $failureRedirect = fn () => redirect()->to(base_url('admin/bookings/create'))->withInput();

        $rules = [
            'name' => 'required|min_length[2]|max_length[160]',
            'phone' => 'required|max_length[20]',
            'email' => 'permit_empty|valid_email|max_length[180]',
            'room_id' => 'required|integer',
            'checkin' => 'required|valid_date[Y-m-d]',
            'checkout' => 'required|valid_date[Y-m-d]',
            'guests' => 'required|integer|greater_than[0]|less_than_equal_to[500]',
            'rooms_required' => 'permit_empty|integer|greater_than[0]|less_than_equal_to[500]',
            'status' => 'required|in_list[pending,confirmed]',
        ];

        if (! $this->validate($rules)) {
            return $failureRedirect()->with('error', $this->validator->listErrors());
        }

        $db = \Config\Database::connect();
        $room = $db->table('rooms')
            ->where('id', (int) $this->request->getPost('room_id'))
            ->where('is_active', 1)
            ->get()
            ->getRowArray();

        if (! $room) {
            return $failureRedirect()->with('error', 'Selected room is not available.');
        }

        $checkin = (string) $this->request->getPost('checkin');
        $checkout = (string) $this->request->getPost('checkout');
        $guests = max(1, (int) $this->request->getPost('guests'));
        $roomsRequired = max(1, (int) ($this->request->getPost('rooms_required') ?: 1));

        if ($checkout <= $checkin) {
            return $failureRedirect()->with('error', 'Checkout date must be after check-in date.');
        }

        if ($roomsRequired > max(1, (int) ($room['available_units'] ?? 1))) {
            return $failureRedirect()->with('error', 'This room type has only ' . max(1, (int) ($room['available_units'] ?? 1)) . ' room(s) in total.');
        }

        $maxGuestsPerRoom = max(1, (int) ($room['max_guests'] ?? 1));
        $minimumRooms = (int) ceil($guests / $maxGuestsPerRoom);

        if ($roomsRequired < $minimumRooms) {
            return $failureRedirect()->with('error', $guests . ' guest(s) require at least ' . $minimumRooms . ' room(s) for this room type.');
        }

        $availability = $this->roomAvailability($room, $checkin, $checkout, null, $roomsRequired);

        if (! $availability['available']) {
            return $failureRedirect()->with('error', 'Only ' . $availability['remaining'] . ' room(s) remain for at least one selected night.');
        }

        $amount = service('paymentService')->calculateRoomAmount($room, $checkin, $checkout, $roomsRequired);
        $now = date('Y-m-d H:i:s');
        $data = [
            'source' => 'admin',
            'booking_code' => service('paymentService')->buildBookingCode(),
            'invoice_number' => $this->buildInvoiceNumber(),
            'name' => trim((string) $this->request->getPost('name')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'email' => trim((string) $this->request->getPost('email')),
            'room_type' => (string) ($room['name'] ?? 'Room'),
            'room_id' => (int) $room['id'],
            'checkin' => $checkin,
            'checkout' => $checkout,
            'guests' => $guests,
            'rooms_required' => $roomsRequired,
            'total_amount' => $amount['total_amount'],
            'currency' => $amount['currency'],
            'payment_required' => 0,
            'payment_gateway' => null,
            'payment_status' => 'not_required',
            'status' => (string) $this->request->getPost('status'),
            'notes' => trim((string) $this->request->getPost('notes')),
            'created_by' => session()->get('admin_id') ? (int) session()->get('admin_id') : null,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $db->table('bookings')->insert($data);
        $id = (int) $db->insertID();

        service('auditLogger')->log('booking.created_manual', 'booking', $id, 'Manual booking created', [
            'booking_code' => $data['booking_code'],
            'room' => $data['room_type'],
            'checkin' => $checkin,
            'checkout' => $checkout,
            'rooms_required' => $roomsRequired,
            'status' => $data['status'],
        ]);

        return redirect()->to(base_url('admin/bookings/' . $id))->with('success', 'Manual booking created.');
    }

    public function show(int $id): string
    {
        $db = \Config\Database::connect();
        $booking = $db->table('bookings')->where('id', $id)->get()->getRowArray();
        if (! $booking) return redirect()->to(base_url('admin/bookings'))->with('error', 'Not found.');

        return $this->render('admin/bookings/show', [
            'title' => 'Booking #'.$id,
            'page' => 'bookings',
            'booking' => $booking,
            'refundLock' => $this->bookingHasActiveRefund($db, $id),
        ]);
    }

    public function updateStatus(int $id)
    {
        $showUrl = base_url('admin/bookings/' . $id);

        if (! service('adminPermissions')->can('bookings.manage')) {
            return redirect()->to($showUrl)->with('error', 'You do not have permission to update bookings.');
        }

        $db = \Config\Database::connect();
        $booking = $db->table('bookings')->where('id', $id)->get()->getRowArray();

        if (! $booking) {
            return redirect()->to(base_url('admin/bookings'))->with('error', 'Booking not found.');
        }

        if ((string) ($booking['status'] ?? '') === 'cancelled' && $this->bookingHasActiveRefund($db, $id)) {
            return redirect()->to($showUrl)->with('error', 'Booking status is locked because a refund has already been initiated.');
        }

        $status = $this->request->getPost('status');
        if (in_array($status, ['pending','confirmed','cancelled'])) {
            $db->table('bookings')
                ->where('id', $id)
                ->update(['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
        }
        return redirect()->to($showUrl)->with('success', 'Booking status updated.');
    }

    public function delete(int $id)
    {
        $showUrl = base_url('admin/bookings/' . $id);

        if (! service('adminPermissions')->canDeleteData()) {
            return redirect()->to($showUrl)->with('error', 'Only owner users can delete records.');
        }

        $db = \Config\Database::connect();

        if ($this->bookingHasPaidOrRefundedTransaction($db, $id)) {
            return redirect()->to($showUrl)->with('error', 'Bookings with paid or refunded transactions cannot be deleted.');
        }

        $db->table('bookings')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/bookings'))->with('success', 'Booking deleted.');
    }

    private function bookingHasActiveRefund($db, int $bookingId): bool
    {
        if (! $db->tableExists('payment_refunds')) {
            return false;
        }

        return $db->table('payment_refunds')
            ->where('booking_id', $bookingId)
            ->whereIn('status', ['pending', 'processed'])
            ->countAllResults() > 0;
    }

    private function bookingHasPaidOrRefundedTransaction($db, int $bookingId): bool
    {
        if ($db->tableExists('payment_transactions')) {
            $paid = $db->table('payment_transactions')
                ->where('booking_id', $bookingId)
                ->where('status', 'paid')
                ->countAllResults() > 0;

            if ($paid) {
                return true;
            }
        }

        return $this->bookingHasActiveRefund($db, $bookingId);
    }

    private function activeRooms(): array
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists('rooms')) {
            return [];
        }

        return $db->table('rooms')
            ->where('is_active', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();
    }

    private function roomAvailability(array $room, string $checkin, string $checkout, ?int $ignoreBookingId = null, int $requestedUnits = 1): array
    {
        $roomId = (int) ($room['id'] ?? 0);
        $availableUnits = max(1, (int) ($room['available_units'] ?? 1));
        $requestedUnits = max(1, $requestedUnits);
        $db = \Config\Database::connect();

        if ($roomId <= 0 || ! $db->tableExists('bookings')) {
            return [
                'available' => true,
                'available_units' => $availableUnits,
                'booked_units' => 0,
                'remaining' => $availableUnits,
            ];
        }

        $maxBookedUnits = 0;
        $start = new \DateTimeImmutable($checkin);
        $end = new \DateTimeImmutable($checkout);
        $useRoomsRequired = $db->fieldExists('rooms_required', 'bookings');

        for ($date = $start; $date < $end; $date = $date->modify('+1 day')) {
            $dateValue = $date->format('Y-m-d');
            $builder = $db->table('bookings')
                ->where('room_id', $roomId)
                ->whereIn('status', ['pending', 'confirmed'])
                ->where('checkin <=', $dateValue)
                ->where('checkout >', $dateValue);

            if ($ignoreBookingId !== null) {
                $builder->where('id !=', $ignoreBookingId);
            }

            $bookedUnits = $useRoomsRequired
                ? (int) ($builder->selectSum('rooms_required', 'booked_units')->get()->getRowArray()['booked_units'] ?? 0)
                : $builder->countAllResults();

            $maxBookedUnits = max($maxBookedUnits, $bookedUnits);

            if ($bookedUnits + $requestedUnits > $availableUnits) {
                return [
                    'available' => false,
                    'available_units' => $availableUnits,
                    'booked_units' => $bookedUnits,
                    'remaining' => max(0, $availableUnits - $bookedUnits),
                ];
            }
        }

        return [
            'available' => true,
            'available_units' => $availableUnits,
            'booked_units' => $maxBookedUnits,
            'remaining' => max(0, $availableUnits - $maxBookedUnits),
        ];
    }

    private function buildInvoiceNumber(): string
    {
        $prefix = strtoupper(preg_replace('/[^A-Z0-9]/i', '', (string) app_setting('receipt_invoice_prefix', 'HHP')) ?: 'HHP');

        return $prefix . '-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
    }

    private function calendarDays(string $month, array $bookings): array
    {
        $days = [];
        $start = new \DateTimeImmutable($month . '-01');
        $totalDays = (int) $start->format('t');

        for ($day = 1; $day <= $totalDays; $day++) {
            $date = $start->setDate((int) $start->format('Y'), (int) $start->format('m'), $day)->format('Y-m-d');
            $days[$date] = [
                'date' => $date,
                'day' => $day,
                'bookings' => [],
            ];
        }

        foreach ($bookings as $booking) {
            $bookingStart = (string) ($booking['checkin'] ?? '');
            $bookingEnd = (string) ($booking['checkout'] ?? '');

            foreach ($days as $date => $_day) {
                if ($bookingStart <= $date && $bookingEnd > $date) {
                    $days[$date]['bookings'][] = $booking;
                }
            }
        }

        foreach ($days as &$day) {
            $occupancy = [];

            foreach ($day['bookings'] as $booking) {
                $roomId = (int) ($booking['room_id'] ?? 0);
                $key = $roomId > 0 ? 'room_' . $roomId : 'booking_' . (int) ($booking['id'] ?? 0);

                if (! isset($occupancy[$key])) {
                    $occupancy[$key] = [
                        'booked' => 0,
                        'available' => max(1, (int) ($booking['available_units'] ?? 1)),
                    ];
                }

                $occupancy[$key]['booked'] += max(1, (int) ($booking['rooms_required'] ?? 1));
            }

            foreach ($day['bookings'] as &$booking) {
                $roomId = (int) ($booking['room_id'] ?? 0);
                $key = $roomId > 0 ? 'room_' . $roomId : 'booking_' . (int) ($booking['id'] ?? 0);
                $units = max(1, (int) ($booking['rooms_required'] ?? 1));
                $booking['occupancy_label'] = $units . ' room' . ($units > 1 ? 's' : '') . ' · ' . ($occupancy[$key]['booked'] ?? 1) . '/' . ($occupancy[$key]['available'] ?? 1) . ' units';
            }
            unset($booking);
        }
        unset($day);

        return array_values($days);
    }
}
