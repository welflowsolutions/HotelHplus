<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

class TridentController extends BaseController
{
    private const STARTER_EVENTS = [
        [
            'title' => 'Weddings & Receptions',
            'description' => 'Elegant celebrations with venue styling, dining coordination, and room for every moment to unfold beautifully.',
            'icon_class' => 'fa-heart',
            'sort_order' => 1,
        ],
        [
            'title' => 'Corporate Events',
            'description' => 'Professional setups for launches, annual meets, business dinners, and team events handled with precision.',
            'icon_class' => 'fa-briefcase',
            'sort_order' => 2,
        ],
        [
            'title' => 'Conferences',
            'description' => 'Flexible seating, sound support, and large-capacity planning for conferences and formal gatherings.',
            'icon_class' => 'fa-chalkboard-user',
            'sort_order' => 3,
        ],
        [
            'title' => 'Birthday Parties',
            'description' => 'Well-organised private functions with custom themes, hospitality support, and easy guest comfort.',
            'icon_class' => 'fa-cake-candles',
            'sort_order' => 4,
        ],
        [
            'title' => 'Social Gatherings',
            'description' => 'Family celebrations, reunions, and community events hosted in a refined and comfortable setting.',
            'icon_class' => 'fa-people-group',
            'sort_order' => 5,
        ],
        [
            'title' => 'Award Ceremonies',
            'description' => 'Formal evenings, stage-led programs, and recognition events with strong on-ground coordination.',
            'icon_class' => 'fa-trophy',
            'sort_order' => 6,
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

    private function eventTable()
    {
        return $this->db()->table('trident_events');
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessTridentAllowed()) {
            return $redirect;
        }

        $db     = $this->db();
        $status = $this->request->getGet('status') ?? 'all';
        $builder = $db->table('trident_enquiries')->orderBy('created_at', 'DESC');
        if ($status !== 'all') $builder->where('status', $status);

        return $this->render('admin/trident/index', [
            'title'      => 'Trident Enquiries',
            'page'       => 'trident',
            'enquiries'  => $builder->get()->getResultArray(),
            'eventCount' => $db->tableExists('trident_events') ? $db->table('trident_events')->countAll() : 0,
            'status'     => $status,
            'counts'     => [
                'all'     => $db->table('trident_enquiries')->countAll(),
                'new'     => $db->table('trident_enquiries')->where('status','new')->countAll(),
                'read'    => $db->table('trident_enquiries')->where('status','read')->countAll(),
                'replied' => $db->table('trident_enquiries')->where('status','replied')->countAll(),
            ],
        ]);
    }

    public function show(int $id): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessTridentAllowed()) {
            return $redirect;
        }

        $db  = $this->db();
        $enq = $db->table('trident_enquiries')->where('id', $id)->get()->getRowArray();
        if (! $enq) return redirect()->to(base_url('admin/trident'))->with('error', 'Not found.');
        if ($enq['status'] === 'new') {
            $db->table('trident_enquiries')->where('id', $id)->update(['status' => 'read', 'updated_at' => date('Y-m-d H:i:s')]);
            $enq['status'] = 'read';
        }
        return $this->render('admin/trident/show', ['title' => 'Trident Enquiry #'.$id, 'page' => 'trident', 'enq' => $enq]);
    }

    public function delete(int $id)
    {
        if ($redirect = $this->denyUnlessTridentAllowed()) {
            return $redirect;
        }

        if (! Services::adminPermissions()->canDeleteData()) {
            return redirect()->back()->with('error', 'Only owner users can delete records.');
        }

        $this->db()->table('trident_enquiries')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/trident'))->with('success', 'Enquiry deleted.');
    }

    public function events(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessTridentAllowed()) {
            return $redirect;
        }

        $events = $this->db()->tableExists('trident_events')
            ? $this->eventTable()->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->get()->getResultArray()
            : [];

        return $this->render('admin/trident/events_index', [
            'title' => 'Trident Event List',
            'page' => 'trident',
            'events' => $events,
        ]);
    }

    public function createEvent(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessTridentAllowed()) {
            return $redirect;
        }

        return $this->render('admin/trident/event_form', [
            'title' => 'Add Trident Event',
            'page' => 'trident',
            'event' => null,
        ]);
    }

    public function storeEvent()
    {
        if ($redirect = $this->denyUnlessTridentAllowed()) {
            return $redirect;
        }

        $rules = [
            'title' => 'required|min_length[3]',
            'description' => 'required|min_length[10]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }

        $this->eventTable()->insert([
            'title' => trim((string) $this->request->getPost('title')),
            'description' => trim((string) $this->request->getPost('description')),
            'icon_class' => trim((string) $this->request->getPost('icon_class')) ?: 'fa-calendar-days',
            'sort_order' => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('admin/trident/events'))->with('success', 'Trident event added successfully.');
    }

    public function editEvent(int $id): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessTridentAllowed()) {
            return $redirect;
        }

        $event = $this->eventTable()->where('id', $id)->get()->getRowArray();

        if (! $event) {
            return redirect()->to(base_url('admin/trident/events'))->with('error', 'Event not found.');
        }

        return $this->render('admin/trident/event_form', [
            'title' => 'Edit Trident Event',
            'page' => 'trident',
            'event' => $event,
        ]);
    }

    public function updateEvent(int $id)
    {
        if ($redirect = $this->denyUnlessTridentAllowed()) {
            return $redirect;
        }

        $event = $this->eventTable()->where('id', $id)->get()->getRowArray();

        if (! $event) {
            return redirect()->to(base_url('admin/trident/events'))->with('error', 'Event not found.');
        }

        $this->eventTable()->where('id', $id)->update([
            'title' => trim((string) $this->request->getPost('title')),
            'description' => trim((string) $this->request->getPost('description')),
            'icon_class' => trim((string) $this->request->getPost('icon_class')) ?: 'fa-calendar-days',
            'sort_order' => (int) ($this->request->getPost('sort_order') ?? 0),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('admin/trident/events'))->with('success', 'Trident event updated successfully.');
    }

    public function deleteEvent(int $id)
    {
        if ($redirect = $this->denyUnlessTridentAllowed()) {
            return $redirect;
        }

        if (! Services::adminPermissions()->canDeleteData()) {
            return redirect()->to(base_url('admin/trident/events'))->with('error', 'Only owner users can delete records.');
        }

        $this->eventTable()->where('id', $id)->delete();
        return redirect()->to(base_url('admin/trident/events'))->with('success', 'Trident event deleted.');
    }

    public function importStarterEvents()
    {
        if ($redirect = $this->denyUnlessTridentAllowed()) {
            return $redirect;
        }

        $existingTitles = array_column($this->eventTable()->select('title')->get()->getResultArray(), 'title');
        $inserted = 0;
        $now = date('Y-m-d H:i:s');

        foreach (self::STARTER_EVENTS as $event) {
            if (in_array($event['title'], $existingTitles, true)) {
                continue;
            }

            $this->eventTable()->insert($event + [
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $inserted++;
        }

        if ($inserted === 0) {
            return redirect()->to(base_url('admin/trident/events'))->with('success', 'Starter Trident events are already imported.');
        }

        return redirect()->to(base_url('admin/trident/events'))->with('success', $inserted . ' starter event' . ($inserted > 1 ? 's' : '') . ' imported successfully.');
    }

    private function denyUnlessTridentAllowed(): ?RedirectResponse
    {
        if (Services::adminPermissions()->can('trident.manage')) {
            return null;
        }

        return redirect()->to(base_url('admin/dashboard'))->with('error', 'You do not have permission to view this page.');
    }
}
