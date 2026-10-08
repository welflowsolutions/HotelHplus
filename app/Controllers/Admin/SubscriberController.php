<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

class SubscriberController extends BaseController
{
    private function render(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);

        return view('admin/layouts/app', $data);
    }

    public function index(): string|RedirectResponse
    {
        if (! Services::adminPermissions()->can('subscribers.view')) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'You do not have permission to view this page.');
        }

        $db = \Config\Database::connect();
        $subscribers = [];
        $counts = [
            'total' => 0,
            'active' => 0,
            'today' => 0,
        ];

        if ($db->tableExists('subscribers')) {
            $subscribers = $db->table('subscribers')
                ->orderBy('subscribed_at', 'DESC')
                ->orderBy('id', 'DESC')
                ->get()
                ->getResultArray();

            $counts['total'] = $db->table('subscribers')->countAll();
            $counts['active'] = $db->table('subscribers')->where('status', 'active')->countAllResults();
            $counts['today'] = $db->table('subscribers')
                ->where('DATE(subscribed_at)', date('Y-m-d'))
                ->countAllResults();
        }

        return $this->render('admin/subscribers/index', [
            'title' => 'Subscribers',
            'page' => 'subscribers',
            'subscribers' => $subscribers,
            'counts' => $counts,
        ]);
    }
}
