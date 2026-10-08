<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

class GalleryController extends BaseController
{
    private const ALLOWED_IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];
    private const ALLOWED_IMAGE_MIME_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif'];
    private const MAX_IMAGE_SIZE_BYTES = 5 * 1024 * 1024;

    private function render(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);
        return view('admin/layouts/app', $data);
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessGalleryAllowed()) {
            return $redirect;
        }

        $images = \Config\Database::connect()
            ->table('gallery')
            ->orderBy('sort_order', 'ASC')
            ->get()->getResultArray();

        return $this->render('admin/gallery/index', [
            'title'  => 'Gallery',
            'page'   => 'gallery',
            'images' => $images,
        ]);
    }

    public function upload()
    {
        if ($redirect = $this->denyUnlessGalleryAllowed()) {
            return $redirect;
        }

        $files = $this->request->getFiles('images');

        if (empty($files['images'])) {
            return redirect()->back()->with('error', 'No files selected.');
        }

        $db      = \Config\Database::connect();
        $uploaded = 0;
        $skipped = 0;
        $targetPath = FCPATH . 'uploads/gallery';

        if (! is_dir($targetPath)) {
            mkdir($targetPath, 0775, true);
        }

        foreach ($files['images'] as $file) {
            if (! $file->isValid() || $file->hasMoved()) continue;

            $extension = strtolower((string) $file->getClientExtension());
            $mimeType = (string) $file->getMimeType();

            if (
                ! in_array($extension, self::ALLOWED_IMAGE_EXTENSIONS, true)
                || ! in_array($mimeType, self::ALLOWED_IMAGE_MIME_TYPES, true)
                || $file->getSize() > self::MAX_IMAGE_SIZE_BYTES
            ) {
                $skipped++;
                continue;
            }

            $newName = $file->getRandomName();
            $file->move($targetPath, $newName);
            $relativePath = 'uploads/gallery/' . $newName;

            if (@getimagesize(FCPATH . $relativePath) === false) {
                @unlink(FCPATH . $relativePath);
                $skipped++;
                continue;
            }

            $db->table('gallery')->insert([
                'filename'   => $relativePath,
                'caption'    => $this->request->getPost('caption') ?? '',
                'category'   => $this->request->getPost('category') ?? 'all',
                'sort_order' => $db->table('gallery')->countAll() + 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $uploaded++;
        }

        if ($uploaded === 0) {
            return redirect()->back()->with('error', 'Please choose valid JPG, PNG, GIF, WebP, or AVIF images up to 5 MB.');
        }

        $message = $uploaded . ' image' . ($uploaded > 1 ? 's' : '') . ' uploaded.';
        if ($skipped > 0) {
            $message .= ' Skipped ' . $skipped . ' invalid file' . ($skipped === 1 ? '' : 's') . '.';
        }

        return redirect()->to(base_url('admin/gallery'))
            ->with('success', $message);
    }

    public function delete(int $id)
    {
        if ($redirect = $this->denyUnlessGalleryAllowed()) {
            return $redirect;
        }

        if (! Services::adminPermissions()->canDeleteData()) {
            return redirect()->to(base_url('admin/gallery'))->with('error', 'Only owner users can delete records.');
        }

        $db  = \Config\Database::connect();
        $img = $db->table('gallery')->where('id', $id)->get()->getRowArray();

        if ($img && file_exists(FCPATH . $img['filename'])) {
            unlink(FCPATH . $img['filename']);
        }

        $db->table('gallery')->where('id', $id)->delete();
        return redirect()->to(base_url('admin/gallery'))->with('success', 'Image deleted.');
    }

    private function denyUnlessGalleryAllowed(): ?RedirectResponse
    {
        if (Services::adminPermissions()->can('media.manage')) {
            return null;
        }

        return redirect()->to(base_url('admin/dashboard'))->with('error', 'You do not have permission to view this page.');
    }
}
