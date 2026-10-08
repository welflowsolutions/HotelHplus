<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

class EventsController extends BaseController
{
    private const PAGE_SETTINGS_KEYS = [
        'events_gallery_images',
    ];

    private const STARTER_SERVICES = [
        [
            'title' => 'Weddings & Receptions',
            'description' => 'Thoughtful celebration planning, guest comfort, and polished coordination for milestone gatherings.',
            'icon_class' => 'fa-heart',
            'sort_order' => 1,
        ],
        [
            'title' => 'Corporate Meets',
            'description' => 'Professional environments for launches, conferences, team meets, and business dinners.',
            'icon_class' => 'fa-briefcase',
            'sort_order' => 2,
        ],
        [
            'title' => 'Birthday Celebrations',
            'description' => 'Flexible event setups for birthdays, anniversaries, and intimate social occasions.',
            'icon_class' => 'fa-cake-candles',
            'sort_order' => 3,
        ],
        [
            'title' => 'Family Gatherings',
            'description' => 'Warm hospitality and practical planning support for reunions and community celebrations.',
            'icon_class' => 'fa-people-group',
            'sort_order' => 4,
        ],
    ];

    private const STARTER_PACKAGES = [
        [
            'title' => 'Essential Package',
            'subtitle' => 'For intimate gatherings',
            'guest_range' => 'Up to 120 guests',
            'price_label' => 'From Rs. 45,000',
            'description' => 'A clean, practical setup for smaller celebrations and focused events.',
            'features' => "Venue setup\nGuest seating\nBasic decor support\nParking assistance",
            'badge_text' => '',
            'is_featured' => 0,
            'sort_order' => 1,
        ],
        [
            'title' => 'Signature Package',
            'subtitle' => 'Best for most events',
            'guest_range' => '120 to 300 guests',
            'price_label' => 'From Rs. 95,000',
            'description' => 'A more complete package with better presentation, smoother coordination, and added guest comfort.',
            'features' => "Venue setup\nEnhanced decor support\nDining coordination\nAV assistance\nGuest flow support",
            'badge_text' => 'Most Popular',
            'is_featured' => 1,
            'sort_order' => 2,
        ],
        [
            'title' => 'Grand Package',
            'subtitle' => 'For larger celebrations',
            'guest_range' => '300+ guests',
            'price_label' => 'Custom quote',
            'description' => 'Tailored planning for larger weddings, conferences, and social occasions.',
            'features' => "Full-event coordination\nPremium decor planning\nCustom layout\nVendor coordination\nDedicated support team",
            'badge_text' => '',
            'is_featured' => 0,
            'sort_order' => 3,
        ],
    ];

    private function render(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);

        return view('admin/layouts/app', $data);
    }

    private function db()
    {
        return \Config\Database::connect();
    }

    private function serviceTable()
    {
        return $this->db()->table('event_services');
    }

    private function packageTable()
    {
        return $this->db()->table('event_packages');
    }

    private function settings(): array
    {
        $rows = $this->db()->table('settings')->get()->getResultArray();

        return array_column($rows, 'value', 'key');
    }

    private function mediaFiles(): array
    {
        return $this->db()->tableExists('media_files')
            ? (new MediaController())->mediaFiles()
            : [];
    }

    private function saveSettings(array $keys): void
    {
        $db = $this->db();

        foreach ($keys as $key) {
            $value = $this->request->getPost($key);
            $exists = $db->table('settings')->where('key', $key)->countAllResults();

            if ($exists) {
                $db->table('settings')->where('key', $key)->update([
                    'value' => $value,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            } else {
                $db->table('settings')->insert([
                    'key' => $key,
                    'value' => $value,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $db = $this->db();
        $status = $this->request->getGet('status') ?? 'all';
        $source = $this->request->getGet('source') ?? 'all';
        $builder = $db->table('event_enquiries')->orderBy('created_at', 'DESC');
        if ($status !== 'all') {
            $builder->where('status', $status);
        }
        if ($source !== 'all') {
            $builder->where('source', $source);
        }

        return $this->render('admin/events/index', [
            'title' => 'Events Manager',
            'page' => 'events',
            'enquiries' => $builder->get()->getResultArray(),
            'status' => $status,
            'source' => $source,
            'serviceCount' => $db->tableExists('event_services') ? $db->table('event_services')->countAll() : 0,
            'packageCount' => $db->tableExists('event_packages') ? $db->table('event_packages')->countAll() : 0,
            'counts' => [
                'all' => $db->table('event_enquiries')->countAll(),
                'new' => $db->table('event_enquiries')->where('status', 'new')->countAll(),
                'read' => $db->table('event_enquiries')->where('status', 'read')->countAll(),
                'replied' => $db->table('event_enquiries')->where('status', 'replied')->countAll(),
                'confirmed' => $db->table('event_enquiries')->where('status', 'confirmed')->countAll(),
                'cancelled' => $db->table('event_enquiries')->where('status', 'cancelled')->countAll(),
                'public' => $db->table('event_enquiries')->where('source', 'public')->countAll(),
                'admin' => $db->table('event_enquiries')->where('source', 'admin')->countAll(),
            ],
        ]);
    }

    public function calendar(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $month = trim((string) ($this->request->getGet('month') ?? date('Y-m')));

        if (! preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = date('Y-m');
        }

        $start = $month . '-01';
        $end = date('Y-m-t', strtotime($start));
        $events = $this->db()->table('event_enquiries')
            ->where('event_date >=', $start)
            ->where('event_date <=', $end)
            ->orderBy('event_date', 'ASC')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        return $this->render('admin/events/calendar', [
            'title' => 'Event Calendar',
            'page' => 'events',
            'month' => $month,
            'calendarDays' => $this->eventCalendarDays($month, $events),
            'prevMonth' => date('Y-m', strtotime($start . ' -1 month')),
            'nextMonth' => date('Y-m', strtotime($start . ' +1 month')),
        ]);
    }

    public function create(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        return $this->render('admin/events/form', [
            'title' => 'Create Event',
            'page' => 'events',
            'services' => $this->db()->tableExists('event_services')
                ? $this->serviceTable()->where('is_active', 1)->orderBy('sort_order', 'ASC')->orderBy('title', 'ASC')->get()->getResultArray()
                : [],
            'event' => null,
        ]);
    }

    public function store(): RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[160]',
            'phone' => 'required|max_length[20]',
            'email' => 'permit_empty|valid_email|max_length[180]',
            'event_type' => 'required|max_length[120]',
            'event_date' => 'required|valid_date[Y-m-d]',
            'guests' => 'permit_empty|max_length[30]',
            'status' => 'required|in_list[read,replied,confirmed,cancelled]',
            'message' => 'permit_empty|max_length[2000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('admin/events/create'))->withInput()->with('error', $this->validator->listErrors());
        }

        $now = date('Y-m-d H:i:s');
        $data = [
            'source' => 'admin',
            'name' => trim((string) $this->request->getPost('name')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'email' => trim((string) $this->request->getPost('email')),
            'event_type' => trim((string) $this->request->getPost('event_type')),
            'event_date' => (string) $this->request->getPost('event_date'),
            'guests' => trim((string) $this->request->getPost('guests')),
            'message' => trim((string) $this->request->getPost('message')),
            'status' => (string) $this->request->getPost('status'),
            'created_by' => session()->get('admin_id') ? (int) session()->get('admin_id') : null,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $this->db()->table('event_enquiries')->insert($data);
        $eventId = (int) $this->db()->insertID();

        Services::auditLogger()->log('event.created', 'event_enquiry', $eventId, 'Manual event record created', [
            'event_type' => $data['event_type'],
            'event_date' => $data['event_date'],
            'status' => $data['status'],
            'source' => 'admin',
        ]);

        return redirect()->to(base_url('admin/events/' . $eventId))->with('success', 'Event created successfully.');
    }

    public function edit(int $id): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $event = $this->db()->table('event_enquiries')->where('id', $id)->get()->getRowArray();

        if (! $event) {
            return redirect()->to(base_url('admin/events'))->with('error', 'Event not found.');
        }

        return $this->render('admin/events/form', [
            'title' => 'Edit Event',
            'page' => 'events',
            'services' => $this->db()->tableExists('event_services')
                ? $this->serviceTable()->where('is_active', 1)->orderBy('sort_order', 'ASC')->orderBy('title', 'ASC')->get()->getResultArray()
                : [],
            'event' => $event,
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $event = $this->db()->table('event_enquiries')->where('id', $id)->get()->getRowArray();

        if (! $event) {
            return redirect()->to(base_url('admin/events'))->with('error', 'Event not found.');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[160]',
            'phone' => 'required|max_length[20]',
            'email' => 'permit_empty|valid_email|max_length[180]',
            'event_type' => 'required|max_length[120]',
            'event_date' => 'required|valid_date[Y-m-d]',
            'guests' => 'permit_empty|max_length[30]',
            'status' => 'required|in_list[read,replied,confirmed,cancelled]',
            'message' => 'permit_empty|max_length[2000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('admin/events/' . $id . '/edit'))->withInput()->with('error', $this->validator->listErrors());
        }

        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'email' => trim((string) $this->request->getPost('email')),
            'event_type' => trim((string) $this->request->getPost('event_type')),
            'event_date' => (string) $this->request->getPost('event_date'),
            'guests' => trim((string) $this->request->getPost('guests')),
            'message' => trim((string) $this->request->getPost('message')),
            'status' => (string) $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db()->table('event_enquiries')->where('id', $id)->update($data);

        Services::auditLogger()->log('event.updated', 'event_enquiry', $id, 'Event record updated', [
            'status_from' => $event['status'] ?? null,
            'status_to' => $data['status'],
            'event_date_from' => $event['event_date'] ?? null,
            'event_date_to' => $data['event_date'],
        ]);

        return redirect()->to(base_url('admin/events/' . $id))->with('success', 'Event updated successfully.');
    }

    public function updateStatus(int $id): RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $status = (string) $this->request->getPost('status');

        if (! in_array($status, ['read', 'replied', 'confirmed', 'cancelled'], true)) {
            return redirect()->to(base_url('admin/events/' . $id))->with('error', 'Invalid event status.');
        }

        $event = $this->db()->table('event_enquiries')->where('id', $id)->get()->getRowArray();

        if (! $event) {
            return redirect()->to(base_url('admin/events'))->with('error', 'Event not found.');
        }

        $this->db()->table('event_enquiries')->where('id', $id)->update([
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Services::auditLogger()->log('event.status_updated', 'event_enquiry', $id, 'Event status updated', [
            'from' => $event['status'] ?? null,
            'to' => $status,
        ]);

        return redirect()->to(base_url('admin/events/' . $id))->with('success', 'Event status updated.');
    }

    public function show(int $id): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $db = $this->db();
        $enquiry = $db->table('event_enquiries')->where('id', $id)->get()->getRowArray();

        if (! $enquiry) {
            return redirect()->to(base_url('admin/events'))->with('error', 'Event not found.');
        }

        if (($enquiry['status'] ?? '') === 'new') {
            $db->table('event_enquiries')->where('id', $id)->update([
                'status' => 'read',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $enquiry['status'] = 'read';
        }

        return $this->render('admin/events/show', [
            'title' => 'Event #' . $id,
            'page' => 'events',
            'enquiry' => $enquiry,
            'eventPayments' => $db->tableExists('event_payments')
                ? $db->table('event_payments')->where('event_enquiry_id', $id)->orderBy('id', 'DESC')->get()->getResultArray()
                : [],
            'paymentSummary' => $this->eventPaymentSummary($id),
        ]);
    }

    public function createPaymentLink(int $id): RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        if (! Services::adminPermissions()->can('payments.view')) {
            return redirect()->to(base_url('admin/events/' . $id))->with('error', 'You do not have permission to create payment links.');
        }

        $rules = [
            'amount' => 'required|numeric|greater_than[0]',
            'notes' => 'permit_empty|max_length[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('admin/events/' . $id))->withInput()->with('error', $this->validator->listErrors());
        }

        $db = $this->db();
        $enquiry = $db->table('event_enquiries')->where('id', $id)->get()->getRowArray();

        if (! $enquiry) {
            return redirect()->to(base_url('admin/events'))->with('error', 'Event enquiry not found.');
        }

        if (! service('paymentService')->gatewayModeActive() || ! service('paymentService')->isReady()) {
            return redirect()->to(base_url('admin/events/' . $id))->withInput()->with('error', 'Payment gateway setup is not ready.');
        }

        $now = date('Y-m-d H:i:s');
        $data = [
            'payment_code' => service('paymentService')->buildEventPaymentCode(),
            'event_enquiry_id' => $id,
            'customer_name' => (string) ($enquiry['name'] ?? ''),
            'customer_email' => (string) ($enquiry['email'] ?? ''),
            'customer_phone' => (string) ($enquiry['phone'] ?? ''),
            'event_type' => (string) ($enquiry['event_type'] ?? 'Event'),
            'event_date' => $enquiry['event_date'] ?? null,
            'guests' => (string) ($enquiry['guests'] ?? ''),
            'amount' => round((float) $this->request->getPost('amount'), 2),
            'currency' => 'INR',
            'payment_gateway' => service('paymentService')->currentProvider(),
            'payment_status' => 'created',
            'notes' => trim((string) $this->request->getPost('notes')),
            'created_by' => session()->get('admin_id') ? (int) session()->get('admin_id') : null,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $db->table('event_payments')->insert($data);
        $paymentId = (int) $db->insertID();

        Services::auditLogger()->log('event_payment.created', 'event_payment', $paymentId, 'Event payment link created', [
            'event_enquiry_id' => $id,
            'payment_code' => $data['payment_code'],
            'amount' => $data['amount'],
        ]);

        $paymentLink = base_url('event-payment/' . $data['payment_code']);
        $emailSent = service('appMailer')->sendEventPaymentLink($data, $paymentLink);
        $message = $emailSent
            ? 'Event payment link created and emailed: ' . $paymentLink
            : 'Event payment link created. Email was not sent, so copy this link: ' . $paymentLink;

        return redirect()->to(base_url('admin/events/' . $id))->with('success', $message);
    }

    public function recordManualPayment(int $id): RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        if (! Services::adminPermissions()->can('payments.view')) {
            return redirect()->to(base_url('admin/events/' . $id))->with('error', 'You do not have permission to record payments.');
        }

        $rules = [
            'manual_amount' => 'required|numeric|greater_than[0]',
            'manual_method' => 'required|in_list[cash,gpay,phonepe,bank_transfer,other]',
            'manual_reference' => 'permit_empty|max_length[160]',
            'manual_received_on' => 'required|regex_match[/^\d{4}-\d{2}-\d{2}$/]',
            'manual_notes' => 'permit_empty|max_length[500]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('admin/events/' . $id))->withInput()->with('error', $this->validator->listErrors());
        }

        $method = (string) $this->request->getPost('manual_method');
        $reference = trim((string) $this->request->getPost('manual_reference'));

        $db = $this->db();
        $enquiry = $db->table('event_enquiries')->where('id', $id)->get()->getRowArray();

        if (! $enquiry) {
            return redirect()->to(base_url('admin/events'))->with('error', 'Event enquiry not found.');
        }

        $now = date('Y-m-d H:i:s');
        $receivedOn = (string) $this->request->getPost('manual_received_on');
        $paidAt = $receivedOn . ' ' . date('H:i:s');
        $amount = round((float) $this->request->getPost('manual_amount'), 2);
        $paymentCode = service('paymentService')->buildEventPaymentCode();
        $manualOrderId = 'MANUAL' . preg_replace('/[^A-Z0-9]/', '', strtoupper($paymentCode)) . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

        $paymentData = [
            'payment_code' => $paymentCode,
            'event_enquiry_id' => $id,
            'customer_name' => (string) ($enquiry['name'] ?? ''),
            'customer_email' => (string) ($enquiry['email'] ?? ''),
            'customer_phone' => (string) ($enquiry['phone'] ?? ''),
            'event_type' => (string) ($enquiry['event_type'] ?? 'Event'),
            'event_date' => $enquiry['event_date'] ?? null,
            'guests' => (string) ($enquiry['guests'] ?? ''),
            'amount' => $amount,
            'currency' => 'INR',
            'payment_gateway' => 'manual',
            'payment_method' => $method,
            'payment_reference' => $reference,
            'payment_status' => 'paid',
            'notes' => trim((string) $this->request->getPost('manual_notes')),
            'paid_at' => $paidAt,
            'created_by' => session()->get('admin_id') ? (int) session()->get('admin_id') : null,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        $db->transStart();
        $db->table('event_payments')->insert($paymentData);
        $paymentId = (int) $db->insertID();

        $db->table('payment_transactions')->insert([
            'booking_id' => null,
            'payment_for' => 'event',
            'event_payment_id' => $paymentId,
            'gateway' => 'manual',
            'payment_method' => $method,
            'gateway_order_id' => $manualOrderId,
            'gateway_payment_id' => $reference !== '' ? $reference : null,
            'payment_reference' => $reference,
            'amount' => $amount,
            'currency' => 'INR',
            'status' => 'paid',
            'session_token' => null,
            'request_payload' => null,
            'response_payload' => null,
            'verified_payload' => json_encode([
                'source' => 'admin_manual_event_payment',
                'method' => $method,
                'reference' => $reference,
                'received_on' => $receivedOn,
                'recorded_by' => session()->get('admin_id') ? (int) session()->get('admin_id') : null,
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'paid_at' => $paidAt,
            'verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        $transactionId = (int) $db->insertID();
        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->to(base_url('admin/events/' . $id))->withInput()->with('error', 'Manual payment could not be recorded.');
        }

        Services::auditLogger()->log('event_payment.manual_recorded', 'event_payment', $paymentId, 'Manual event payment recorded', [
            'event_enquiry_id' => $id,
            'transaction_id' => $transactionId,
            'payment_code' => $paymentCode,
            'amount' => $amount,
            'method' => $method,
            'reference' => $reference,
        ]);

        return redirect()->to(base_url('admin/events/' . $id))->with('success', 'Manual event advance recorded successfully.');
    }

    public function cancelPaymentLink(int $eventId, int $paymentId): RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        if (! Services::adminPermissions()->can('payments.view')) {
            return redirect()->to(base_url('admin/events/' . $eventId))->with('error', 'You do not have permission to cancel payment links.');
        }

        $db = $this->db();
        $payment = $db->table('event_payments')
            ->where('id', $paymentId)
            ->where('event_enquiry_id', $eventId)
            ->get()
            ->getRowArray();

        if (! $payment) {
            return redirect()->to(base_url('admin/events/' . $eventId))->with('error', 'Event payment link not found.');
        }

        if ((string) ($payment['payment_gateway'] ?? '') === 'manual') {
            return redirect()->to(base_url('admin/events/' . $eventId))->with('error', 'Manual advances cannot be cancelled from payment link actions.');
        }

        $status = (string) ($payment['payment_status'] ?? 'created');

        if ($status === 'paid') {
            return redirect()->to(base_url('admin/events/' . $eventId))->with('error', 'Paid event payments cannot be cancelled.');
        }

        if (! in_array($status, ['created', 'pending'], true)) {
            return redirect()->to(base_url('admin/events/' . $eventId))->with('error', 'Only active payment links can be cancelled.');
        }

        $now = date('Y-m-d H:i:s');
        $db->transStart();
        $db->table('event_payments')->where('id', $paymentId)->update([
            'payment_status' => 'cancelled',
            'updated_at' => $now,
        ]);
        $db->table('payment_transactions')
            ->where('payment_for', 'event')
            ->where('event_payment_id', $paymentId)
            ->whereIn('status', ['created', 'checkout_ready', 'pending'])
            ->update([
                'status' => 'cancelled',
                'updated_at' => $now,
            ]);
        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->to(base_url('admin/events/' . $eventId))->with('error', 'Payment link could not be cancelled.');
        }

        Services::auditLogger()->log('event_payment.cancelled', 'event_payment', $paymentId, 'Event payment link cancelled', [
            'event_enquiry_id' => $eventId,
            'payment_code' => $payment['payment_code'] ?? '',
            'amount' => $payment['amount'] ?? null,
        ]);

        return redirect()->to(base_url('admin/events/' . $eventId))->with('success', 'Payment link cancelled. The guest can no longer pay with that link.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        if (! Services::adminPermissions()->canDeleteData()) {
            return redirect()->back()->with('error', 'Only owner users can delete records.');
        }

        $this->db()->table('event_enquiries')->where('id', $id)->delete();

        return redirect()->to(base_url('admin/events'))->with('success', 'Event enquiry deleted.');
    }

    public function page(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        return $this->render('admin/events/page', [
            'title' => 'Events Page',
            'page' => 'events',
            'settings' => $this->settings(),
            'mediaFiles' => $this->mediaFiles(),
        ]);
    }

    public function updatePage()
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $this->saveSettings(self::PAGE_SETTINGS_KEYS);

        return redirect()->to(base_url('admin/events/page'))->with('success', 'Events page settings saved successfully.');
    }

    public function services(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $services = $this->db()->tableExists('event_services')
            ? $this->serviceTable()->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->get()->getResultArray()
            : [];

        return $this->render('admin/events/services_index', [
            'title' => 'Manage Event Services',
            'page' => 'events',
            'services' => $services,
        ]);
    }

    public function createService(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        return $this->render('admin/events/service_form', [
            'title' => 'Add Event Service',
            'page' => 'events',
            'service' => null,
        ]);
    }

    public function storeService()
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $rules = [
            'title' => 'required|min_length[3]',
            'description' => 'required|min_length[10]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $this->serviceTable()->insert([
            'title' => trim((string) $this->request->getPost('title')),
            'description' => trim((string) $this->request->getPost('description')),
            'icon_class' => trim((string) $this->request->getPost('icon_class')) ?: 'fa-calendar-days',
            'sort_order' => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('admin/events/services'))->with('success', 'Event service added successfully.');
    }

    public function editService(int $id): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $service = $this->serviceTable()->where('id', $id)->get()->getRowArray();

        if (! $service) {
            return redirect()->to(base_url('admin/events/services'))->with('error', 'Event service not found.');
        }

        return $this->render('admin/events/service_form', [
            'title' => 'Edit Event Service',
            'page' => 'events',
            'service' => $service,
        ]);
    }

    public function updateService(int $id)
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $service = $this->serviceTable()->where('id', $id)->get()->getRowArray();

        if (! $service) {
            return redirect()->to(base_url('admin/events/services'))->with('error', 'Event service not found.');
        }

        $this->serviceTable()->where('id', $id)->update([
            'title' => trim((string) $this->request->getPost('title')),
            'description' => trim((string) $this->request->getPost('description')),
            'icon_class' => trim((string) $this->request->getPost('icon_class')) ?: 'fa-calendar-days',
            'sort_order' => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('admin/events/services'))->with('success', 'Event service updated successfully.');
    }

    public function deleteService(int $id)
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        if (! Services::adminPermissions()->canDeleteData()) {
            return redirect()->to(base_url('admin/events/services'))->with('error', 'Only owner users can delete records.');
        }

        $this->serviceTable()->where('id', $id)->delete();

        return redirect()->to(base_url('admin/events/services'))->with('success', 'Event service deleted.');
    }

    public function importStarterServices()
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $existingTitles = array_column($this->serviceTable()->select('title')->get()->getResultArray(), 'title');
        $inserted = 0;
        $now = date('Y-m-d H:i:s');

        foreach (self::STARTER_SERVICES as $service) {
            if (in_array($service['title'], $existingTitles, true)) {
                continue;
            }

            $this->serviceTable()->insert($service + [
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $inserted++;
        }

        if ($inserted === 0) {
            return redirect()->to(base_url('admin/events/services'))->with('success', 'Starter event services are already imported.');
        }

        return redirect()->to(base_url('admin/events/services'))->with('success', $inserted . ' starter service' . ($inserted > 1 ? 's' : '') . ' imported successfully.');
    }

    public function packages(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $packages = $this->db()->tableExists('event_packages')
            ? $this->packageTable()->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->get()->getResultArray()
            : [];

        return $this->render('admin/events/packages_index', [
            'title' => 'Manage Event Packages',
            'page' => 'events',
            'packages' => $packages,
        ]);
    }

    public function createPackage(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        return $this->render('admin/events/package_form', [
            'title' => 'Add Event Package',
            'page' => 'events',
            'package' => null,
        ]);
    }

    public function storePackage()
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $rules = [
            'title' => 'required|min_length[3]',
            'price_label' => 'required|min_length[2]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $this->packageTable()->insert([
            'title' => trim((string) $this->request->getPost('title')),
            'subtitle' => trim((string) $this->request->getPost('subtitle')),
            'guest_range' => trim((string) $this->request->getPost('guest_range')),
            'price_label' => trim((string) $this->request->getPost('price_label')),
            'description' => trim((string) $this->request->getPost('description')),
            'features' => trim((string) $this->request->getPost('features')),
            'badge_text' => trim((string) $this->request->getPost('badge_text')),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'sort_order' => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('admin/events/packages'))->with('success', 'Event package added successfully.');
    }

    public function editPackage(int $id): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $package = $this->packageTable()->where('id', $id)->get()->getRowArray();

        if (! $package) {
            return redirect()->to(base_url('admin/events/packages'))->with('error', 'Event package not found.');
        }

        return $this->render('admin/events/package_form', [
            'title' => 'Edit Event Package',
            'page' => 'events',
            'package' => $package,
        ]);
    }

    public function updatePackage(int $id)
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $package = $this->packageTable()->where('id', $id)->get()->getRowArray();

        if (! $package) {
            return redirect()->to(base_url('admin/events/packages'))->with('error', 'Event package not found.');
        }

        $this->packageTable()->where('id', $id)->update([
            'title' => trim((string) $this->request->getPost('title')),
            'subtitle' => trim((string) $this->request->getPost('subtitle')),
            'guest_range' => trim((string) $this->request->getPost('guest_range')),
            'price_label' => trim((string) $this->request->getPost('price_label')),
            'description' => trim((string) $this->request->getPost('description')),
            'features' => trim((string) $this->request->getPost('features')),
            'badge_text' => trim((string) $this->request->getPost('badge_text')),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'sort_order' => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('admin/events/packages'))->with('success', 'Event package updated successfully.');
    }

    public function deletePackage(int $id)
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        if (! Services::adminPermissions()->canDeleteData()) {
            return redirect()->to(base_url('admin/events/packages'))->with('error', 'Only owner users can delete records.');
        }

        $this->packageTable()->where('id', $id)->delete();

        return redirect()->to(base_url('admin/events/packages'))->with('success', 'Event package deleted.');
    }

    public function importStarterPackages()
    {
        if ($redirect = $this->denyUnlessEventsAllowed()) {
            return $redirect;
        }

        $existingTitles = array_column($this->packageTable()->select('title')->get()->getResultArray(), 'title');
        $inserted = 0;
        $now = date('Y-m-d H:i:s');

        foreach (self::STARTER_PACKAGES as $package) {
            if (in_array($package['title'], $existingTitles, true)) {
                continue;
            }

            $this->packageTable()->insert($package + [
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $inserted++;
        }

        if ($inserted === 0) {
            return redirect()->to(base_url('admin/events/packages'))->with('success', 'Starter event packages are already imported.');
        }

        return redirect()->to(base_url('admin/events/packages'))->with('success', $inserted . ' starter package' . ($inserted > 1 ? 's' : '') . ' imported successfully.');
    }

    private function denyUnlessEventsAllowed(): ?RedirectResponse
    {
        if (Services::adminPermissions()->can('events.manage')) {
            return null;
        }

        return redirect()->to(base_url('admin/dashboard'))->with('error', 'You do not have permission to view this page.');
    }

    private function eventCalendarDays(string $month, array $events): array
    {
        $start = new \DateTimeImmutable($month . '-01');
        $daysInMonth = (int) $start->format('t');
        $eventsByDate = [];

        foreach ($events as $event) {
            $date = (string) ($event['event_date'] ?? '');

            if ($date === '') {
                continue;
            }

            $eventsByDate[$date][] = $event;
        }

        $days = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $start->setDate((int) $start->format('Y'), (int) $start->format('m'), $day)->format('Y-m-d');
            $dayEvents = $eventsByDate[$date] ?? [];
            $days[] = [
                'day' => $day,
                'date' => $date,
                'events' => $dayEvents,
                'confirmed_count' => count(array_filter($dayEvents, static fn (array $event): bool => ($event['status'] ?? '') === 'confirmed')),
            ];
        }

        return $days;
    }

    private function eventPaymentSummary(int $eventId): array
    {
        if (! $this->db()->tableExists('event_payments')) {
            return [
                'paid_amount' => 0.0,
                'pending_amount' => 0.0,
                'cancelled_amount' => 0.0,
                'paid_count' => 0,
                'pending_count' => 0,
                'cancelled_count' => 0,
                'total_count' => 0,
            ];
        }

        $rows = $this->db()->table('event_payments')
            ->select('payment_status, amount')
            ->where('event_enquiry_id', $eventId)
            ->get()
            ->getResultArray();

        $summary = [
            'paid_amount' => 0.0,
            'pending_amount' => 0.0,
            'cancelled_amount' => 0.0,
            'paid_count' => 0,
            'pending_count' => 0,
            'cancelled_count' => 0,
            'total_count' => count($rows),
        ];

        foreach ($rows as $row) {
            $status = (string) ($row['payment_status'] ?? 'created');
            $amount = (float) ($row['amount'] ?? 0);

            if ($status === 'paid') {
                $summary['paid_amount'] += $amount;
                $summary['paid_count']++;
                continue;
            }

            if ($status === 'cancelled') {
                $summary['cancelled_amount'] += $amount;
                $summary['cancelled_count']++;
                continue;
            }

            if (in_array($status, ['created', 'pending'], true)) {
                $summary['pending_amount'] += $amount;
                $summary['pending_count']++;
            }
        }

        return $summary;
    }
}
