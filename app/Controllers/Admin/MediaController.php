<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MediaFileModel;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

class MediaController extends BaseController
{
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'ico', 'avif'];
    private const ALLOWED_MIME_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/x-icon', 'image/vnd.microsoft.icon', 'image/avif'];
    private const WEBP_CONVERTIBLE_MIME_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    private function render(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);

        return view('admin/layouts/app', $data);
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessMediaAllowed()) {
            return $redirect;
        }

        return $this->render('admin/media/index', [
            'title' => 'Media Library',
            'page' => 'media',
            'files' => $this->mediaFiles(),
            'styles' => view('admin/media/_styles'),
            'scripts' => view('admin/media/_scripts'),
        ]);
    }

    public function upload()
    {
        if ($response = $this->denyUnlessMediaAllowed()) {
            return $response;
        }

        $files = $this->request->getFileMultiple('media_files');

        if ($files === []) {
            if ($this->wantsJson()) {
                return $this->response
                    ->setStatusCode(422)
                    ->setJSON($this->jsonPayload(false, 'Please choose at least one image.'));
            }

            return redirect()->back()->with('error', 'Please choose at least one image.');
        }

        $folder = 'uploads/media/' . date('Y/m');
        $targetPath = FCPATH . $folder;
        $model = new MediaFileModel();
        $uploaded = 0;
        $uploadedFiles = [];
        $skipped = [];

        if (! is_dir($targetPath)) {
            mkdir($targetPath, 0775, true);
        }

        foreach ($files as $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }

            $extension = strtolower((string) $file->getClientExtension());
            $mimeType = (string) $file->getMimeType();
            $clientName = (string) $file->getClientName();

            if (! in_array($extension, self::ALLOWED_EXTENSIONS, true) || ! in_array($mimeType, self::ALLOWED_MIME_TYPES, true)) {
                $skipped[] = $clientName;
                continue;
            }

            if ($file->getSizeByUnit('mb') > 5) {
                $skipped[] = $clientName;
                continue;
            }

            $newName = $file->getRandomName();
            $file->move($targetPath, $newName);

            $relativePath = $folder . '/' . $newName;
            [$width, $height] = $this->imageDimensions(FCPATH . $relativePath);

            if ($width === null || $height === null) {
                @unlink(FCPATH . $relativePath);
                $skipped[] = $clientName;
                continue;
            }

            $model->insert([
                'file_name'          => $newName,
                'original_file_name' => $newName,
                'original_name'      => $clientName,
                'path'               => $relativePath,
                'original_path'      => $relativePath,
                'mime_type'          => $mimeType,
                'original_mime_type' => $mimeType,
                'size'               => $file->getSize(),
                'original_size'      => $file->getSize(),
                'alt_text'           => '',
                'width'              => $width,
                'height'             => $height,
            ]);

            $uploaded++;
            $uploadedFiles[] = $this->mediaPayload((int) $model->getInsertID());
        }

        if ($uploaded === 0) {
            if ($this->wantsJson()) {
                return $this->response
                    ->setStatusCode(422)
                    ->setJSON($this->jsonPayload(false, 'Please choose valid JPG, PNG, GIF, WebP, AVIF, or ICO images up to 5 MB.', [], $skipped));
            }

            return redirect()->back()->with('error', 'Please choose valid JPG, PNG, GIF, WebP, AVIF, or ICO images up to 5 MB.');
        }

        $message = $uploaded === 1 ? 'Image uploaded successfully.' : $uploaded . ' images uploaded successfully.';
        if ($skipped !== []) {
            $message .= ' Skipped ' . count($skipped) . ' invalid file' . (count($skipped) === 1 ? '' : 's') . '.';
        }

        if ($this->wantsJson()) {
            return $this->response->setJSON($this->jsonPayload(true, $message, $uploadedFiles, $skipped));
        }

        return redirect()->back()->with('success', $message);
    }

    public function update(int $id)
    {
        if ($response = $this->denyUnlessMediaAllowed()) {
            return $response;
        }

        $model = new MediaFileModel();
        $file = $model->find($id);

        if (! $file) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON($this->jsonPayload(false, 'Media file not found.'));
        }

        $altText = trim((string) $this->request->getPost('alt_text'));
        $useWebp = $this->request->getPost('use_webp') === '1';
        $alreadyWebp = (string) ($file['mime_type'] ?? '') === 'image/webp';

        $updateData = ['alt_text' => $altText];

        if ($useWebp) {
            if ($alreadyWebp) {
                $updateData += [
                    'file_name' => $file['file_name'] ?? '',
                    'path' => $file['path'] ?? '',
                    'mime_type' => 'image/webp',
                    'size' => $file['size'] ?? null,
                    'width' => $file['width'] ?? null,
                    'height' => $file['height'] ?? null,
                ];
            } elseif (! $this->canCreateWebp($file)) {
                return $this->response
                    ->setStatusCode(422)
                    ->setJSON($this->jsonPayload(false, 'This file type cannot be converted to WebP.'));
            } else {
                $webpPath = $this->ensureWebpVariant($file);
                if ($webpPath === null) {
                    return $this->response
                        ->setStatusCode(422)
                        ->setJSON($this->jsonPayload(false, 'WebP copy could not be generated for this file.'));
                }

                [$finalWidth, $finalHeight] = $this->imageDimensions(FCPATH . $webpPath);

                $updateData += [
                    'file_name' => basename($webpPath),
                    'path' => $webpPath,
                    'mime_type' => 'image/webp',
                    'size' => is_file(FCPATH . $webpPath) ? filesize(FCPATH . $webpPath) : ($file['size'] ?? null),
                    'width' => $finalWidth ?: ($file['width'] ?? null),
                    'height' => $finalHeight ?: ($file['height'] ?? null),
                ];
            }
        } else {
            $originalPath = (string) ($file['original_path'] ?? '');
            if ($originalPath !== '') {
                [$width, $height] = $this->imageDimensions(FCPATH . $originalPath);

                $updateData += [
                    'file_name' => $file['original_file_name'] ?: basename($originalPath),
                    'path' => $originalPath,
                    'mime_type' => $file['original_mime_type'] ?: $file['mime_type'],
                    'size' => $file['original_size'] ?: $file['size'],
                    'width' => $width,
                    'height' => $height,
                ];
            }
        }

        $model->update($id, $updateData);

        $payload = $this->jsonPayload(
            true,
            ($useWebp && ! $alreadyWebp) ? 'Media updated with WebP copy.' : 'Media updated successfully.'
        );
        $payload['file'] = $this->mediaPayload($id);

        return $this->response->setJSON($payload);
    }

    public function delete(int $id)
    {
        if ($response = $this->denyUnlessMediaAllowed()) {
            return $response;
        }

        if (! service('adminPermissions')->canDeleteData()) {
            if ($this->wantsJson()) {
                return $this->response
                    ->setStatusCode(403)
                    ->setJSON($this->jsonPayload(false, 'Only owner users can delete records.'));
            }

            return redirect()->back()->with('error', 'Only owner users can delete records.');
        }

        $model = new MediaFileModel();
        $file = $model->find($id);

        if (! $file) {
            if ($this->wantsJson()) {
                return $this->response
                    ->setStatusCode(404)
                    ->setJSON($this->jsonPayload(false, 'Media file not found.'));
            }

            return redirect()->back()->with('error', 'Media file not found.');
        }

        $paths = array_unique(array_filter([
            (string) ($file['path'] ?? ''),
            (string) ($file['original_path'] ?? ''),
        ]));

        foreach ($paths as $path) {
            if (! str_starts_with($path, 'uploads/media/')) {
                continue;
            }

            $absolutePath = FCPATH . $path;
            if (is_file($absolutePath)) {
                unlink($absolutePath);
            }
        }

        $model->delete($id);

        if ($this->wantsJson()) {
            return $this->response->setJSON($this->jsonPayload(true, 'Image deleted successfully.'));
        }

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    public function mediaFiles(): array
    {
        if (! \Config\Database::connect()->tableExists('media_files')) {
            return [];
        }

        return array_map(
            fn (array $file): array => $this->enrichMedia($file),
            (new MediaFileModel())->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->findAll()
        );
    }

    private function mediaPayload(int $id): array
    {
        $file = (new MediaFileModel())->find($id);

        return $file ? $this->enrichMedia($file) : [];
    }

    private function enrichMedia(array $file): array
    {
        $file['url'] = media_url((string) ($file['path'] ?? ''));
        $file['original_url'] = ! empty($file['original_path']) ? media_url((string) $file['original_path']) : $file['url'];
        $file['alt_text'] = (string) ($file['alt_text'] ?? '');
        $file['width'] = isset($file['width']) ? (int) $file['width'] : null;
        $file['height'] = isset($file['height']) ? (int) $file['height'] : null;
        $file['original_size'] = isset($file['original_size']) ? (int) $file['original_size'] : null;
        $file['size'] = isset($file['size']) ? (int) $file['size'] : null;
        $file['is_edited'] = ! empty($file['original_path']) && ($file['original_path'] !== ($file['path'] ?? ''));
        $file['webp_enabled'] = (string) ($file['mime_type'] ?? '') === 'image/webp';
        $file['webp_convertible'] = $this->canCreateWebp($file);

        return $file;
    }

    private function imageDimensions(string $absolutePath): array
    {
        if (! is_file($absolutePath)) {
            return [null, null];
        }

        $size = @getimagesize($absolutePath);
        if (! is_array($size)) {
            return [null, null];
        }

        return [
            isset($size[0]) ? (int) $size[0] : null,
            isset($size[1]) ? (int) $size[1] : null,
        ];
    }

    private function canCreateWebp(array $file): bool
    {
        $originalMime = (string) ($file['original_mime_type'] ?? $file['mime_type'] ?? '');
        $originalPath = (string) ($file['original_path'] ?? $file['path'] ?? '');

        return $originalPath !== ''
            && $originalMime !== 'image/webp'
            && in_array($originalMime, self::WEBP_CONVERTIBLE_MIME_TYPES, true)
            && function_exists('imagewebp');
    }

    private function ensureWebpVariant(array $file): ?string
    {
        if (! $this->canCreateWebp($file)) {
            return null;
        }

        $currentPath = (string) ($file['path'] ?? '');
        if ((string) ($file['mime_type'] ?? '') === 'image/webp' && $currentPath !== '' && is_file(FCPATH . $currentPath)) {
            return $currentPath;
        }

        $sourcePath = (string) ($file['original_path'] ?? $file['path'] ?? '');
        $sourceAbsolutePath = FCPATH . $sourcePath;
        if (! is_file($sourceAbsolutePath)) {
            return null;
        }

        $folder = 'uploads/media/webp/' . date('Y/m');
        $targetDirectory = FCPATH . $folder;
        if (! is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0775, true);
        }

        $webpName = pathinfo((string) ($file['original_file_name'] ?? $file['file_name'] ?? ''), PATHINFO_FILENAME);
        $webpName = $webpName !== '' ? $webpName . '-' . substr(sha1($sourcePath), 0, 8) . '.webp' : bin2hex(random_bytes(8)) . '.webp';
        $webpPath = $folder . '/' . $webpName;
        $webpAbsolutePath = FCPATH . $webpPath;

        if (is_file($webpAbsolutePath)) {
            return $webpPath;
        }

        $binary = @file_get_contents($sourceAbsolutePath);
        if ($binary === false) {
            return null;
        }

        $image = @imagecreatefromstring($binary);
        if ($image === false) {
            return null;
        }

        imagesavealpha($image, true);
        $written = imagewebp($image, $webpAbsolutePath, 85);
        imagedestroy($image);

        return $written ? $webpPath : null;
    }

    private function wantsJson(): bool
    {
        return $this->request->isAJAX()
            || str_contains((string) $this->request->getHeaderLine('Accept'), 'application/json');
    }

    private function jsonPayload(bool $success, string $message, array $files = [], array $skipped = []): array
    {
        return [
            'success' => $success,
            'message' => $message,
            'files' => $files,
            'skipped' => $skipped,
            'csrf' => [
                'name' => csrf_token(),
                'hash' => csrf_hash(),
            ],
        ];
    }

    private function denyUnlessMediaAllowed()
    {
        if (Services::adminPermissions()->can('media.manage')) {
            return null;
        }

        if ($this->wantsJson()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to perform this action.',
            ]);
        }

        return redirect()->to(base_url('admin/dashboard'))->with('error', 'You do not have permission to view this page.');
    }
}
