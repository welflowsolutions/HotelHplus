<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class EnquiryController extends BaseController
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

        $builder = $db->table('enquiries')->orderBy('created_at', 'DESC');
        if ($status !== 'all') {
            $builder->where('status', $status);
        }

        return $this->render('admin/enquiries/index', [
            'title'      => 'Enquiries',
            'page'       => 'enquiries',
            'enquiries'  => $builder->get()->getResultArray(),
            'status'     => $status,
            'counts'     => [
                'all'     => $db->table('enquiries')->countAll(),
                'new'     => $db->table('enquiries')->where('status','new')->countAll(),
                'read'    => $db->table('enquiries')->where('status','read')->countAll(),
                'replied' => $db->table('enquiries')->where('status','replied')->countAll(),
            ],
        ]);
    }

    public function show(int $id): string
    {
        $db  = \Config\Database::connect();
        $enq = $db->table('enquiries')->where('id', $id)->get()->getRowArray();

        if (! $enq) {
            return redirect()->to(base_url('admin/enquiries'))->with('error', 'Enquiry not found.');
        }

        // Mark as read
        if ($enq['status'] === 'new') {
            $db->table('enquiries')->where('id', $id)->update(['status' => 'read', 'updated_at' => date('Y-m-d H:i:s')]);
            $enq['status'] = 'read';
        }

        return $this->render('admin/enquiries/show', [
            'title' => 'Enquiry #' . $id,
            'page'  => 'enquiries',
            'enq'   => $enq,
        ]);
    }

    public function delete(int $id)
    {
        if (! service('adminPermissions')->canDeleteData()) {
            return redirect()->back()->with('error', 'Only owner users can delete records.');
        }

        \Config\Database::connect()->table('enquiries')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/enquiries'))->with('success', 'Enquiry deleted.');
    }
}
