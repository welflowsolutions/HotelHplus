<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

class ActivityLogController extends BaseController
{
    private function render(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);

        return view('admin/layouts/app', $data);
    }

    public function index(): string|RedirectResponse
    {
        if (! Services::adminPermissions()->can('activity_logs.view')) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'You do not have permission to view this page.');
        }

        $db = \Config\Database::connect();
        $logs = [];

        if ($db->tableExists('admin_activity_logs')) {
            $logs = $db->table('admin_activity_logs')
                ->orderBy('created_at', 'DESC')
                ->orderBy('id', 'DESC')
                ->limit(200)
                ->get()
                ->getResultArray();
        }

        return $this->render('admin/activity_logs/index', [
            'title' => 'Activity Logs',
            'page' => 'activity_logs',
            'logs' => $logs,
        ]);
    }
}
