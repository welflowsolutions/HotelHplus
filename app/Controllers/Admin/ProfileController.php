<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use DateTimeImmutable;

class ProfileController extends BaseController
{
    private function render(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);
        return view('admin/layouts/app', $data);
    }

    public function index(): string
    {
        $user = $this->currentUser();

        if (! $user) {
            return redirect()->to(base_url('admin/login'))
                ->with('error', 'Please log in to access your profile.');
        }

        return $this->render('admin/profile/index', [
            'title'       => 'Profile',
            'page'        => 'profile',
            'user'        => $user,
            'mediaFiles'  => \Config\Database::connect()->tableExists('media_files') ? (new MediaController())->mediaFiles() : [],
            'activePanel' => session()->getFlashdata('active_profile_panel') ?? 'info',
            'passwordErrors' => session()->getFlashdata('password_errors') ?? [],
        ]);
    }

    public function update()
    {
        $user = $this->currentUser();

        if (! $user) {
            return redirect()->to(base_url('admin/login'))
                ->with('error', 'Please log in to update your profile.');
        }

        $rules = [
            'name'  => 'required|min_length[3]|max_length[120]',
            'email' => 'required|valid_email|max_length[180]',
            'phone' => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('admin/profile'))
                ->withInput()
                ->with('active_profile_panel', 'info')
                ->with('error', $this->validator->getError('name') ?: $this->validator->getError('email'));
        }

        $model = new AdminModel();
        $id    = (int) $user['id'];

        $email = trim((string) $this->request->getPost('email'));

        $emailExists = $model->where('email', $email)
            ->where('id !=', $id)
            ->first();

        if ($emailExists) {
            return redirect()->to(base_url('admin/profile'))
                ->withInput()
                ->with('active_profile_panel', 'info')
                ->with('error', 'That email address is already in use.');
        }

        $emailChanged = $email !== ($user['email'] ?? '');

        if ($emailChanged && ! $this->canChangeEmail($user)) {
            return redirect()->to(base_url('admin/profile'))
                ->withInput()
                ->with('active_profile_panel', 'info')
                ->with('error', 'Email can be changed once every 30 days. You can change it again after ' . $this->nextEmailChangeAt($user)->format('d M Y, h:i A') . '.');
        }

        $data = [
            'name'  => trim((string) $this->request->getPost('name')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'email' => $email,
        ];

        $selectedPhotoPath = trim((string) $this->request->getPost('profile_photo_path'));
        if ($selectedPhotoPath !== '') {
            $data['profile_photo'] = media_active_path($selectedPhotoPath);
        } elseif ($this->request->getPost('profile_photo_path') !== null) {
            $data['profile_photo'] = null;
        }

        if ($emailChanged) {
            $data['email_verified_at'] = null;
            $data['email_changed_at']  = date('Y-m-d H:i:s');
        }

        $photo = $this->request->getFile('profile_photo');
        if ($photo && $photo->isValid() && ! $photo->hasMoved()) {
            $photoRules = ['profile_photo' => 'uploaded[profile_photo]|is_image[profile_photo]|max_size[profile_photo,2048]'];

            if (! $this->validate($photoRules)) {
                return redirect()->to(base_url('admin/profile'))
                    ->withInput()
                    ->with('active_profile_panel', 'info')
                    ->with('error', $this->validator->getError('profile_photo'));
            }

            $uploadPath = FCPATH . 'uploads/profile-photos';
            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $newName = $photo->getRandomName();
            $photo->move($uploadPath, $newName);
            $data['profile_photo'] = 'uploads/profile-photos/' . $newName;

            $oldPhoto = $user['profile_photo'] ?? null;
            if ($oldPhoto && str_starts_with($oldPhoto, 'uploads/profile-photos/')) {
                $oldPhotoPath = FCPATH . $oldPhoto;
                if (is_file($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }
        }

        $model->update($id, $data);
        $updated = $model->find($id);
        $this->refreshAdminSession($updated);

        return redirect()->to(base_url('admin/profile'))
            ->with('active_profile_panel', 'info')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePassword()
    {
        $user = $this->currentUser();

        if (! $user) {
            return redirect()->to(base_url('admin/login'))
                ->with('error', 'Please log in to update your password.');
        }

        $currentPassword = trim((string) $this->request->getPost('current_password'));
        $newPassword = trim((string) $this->request->getPost('new_password'));
        $newPasswordConfirmation = trim((string) $this->request->getPost('new_password_confirmation'));

        if ($currentPassword === '' || $newPassword === '' || $newPasswordConfirmation === '') {
            return redirect()->to(base_url('admin/profile'))
                ->withInput()
                ->with('active_profile_panel', 'password')
                ->with('password_errors', [
                    'current_password' => $currentPassword === '' ? 'Current password is required.' : null,
                    'new_password' => $newPassword === '' ? 'New password is required.' : null,
                    'new_password_confirmation' => $newPasswordConfirmation === '' ? 'Please confirm your new password.' : null,
                ])
                ->with('error', 'Please correct the highlighted password fields.');
        }

        $rules = [
            'current_password'          => 'required',
            'new_password'              => 'required|min_length[8]',
            'new_password_confirmation' => 'required|matches[new_password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('admin/profile'))
                ->withInput()
                ->with('active_profile_panel', 'password')
                ->with('password_errors', [
                    'current_password' => $this->validator->getError('current_password') ?: null,
                    'new_password' => $this->validator->getError('new_password') ?: null,
                    'new_password_confirmation' => $this->validator->getError('new_password_confirmation') ?: null,
                ])
                ->with('error', $this->validator->getError('current_password') ?: $this->validator->getError('new_password') ?: $this->validator->getError('new_password_confirmation'));
        }

        if (! password_verify($currentPassword, $user['password'])) {
            return redirect()->to(base_url('admin/profile'))
                ->with('active_profile_panel', 'password')
                ->with('password_errors', [
                    'current_password' => 'Current password is incorrect.',
                ])
                ->with('error', 'Current password is incorrect.');
        }

        if (password_verify($newPassword, $user['password'])) {
            return redirect()->to(base_url('admin/profile'))
                ->with('active_profile_panel', 'password')
                ->with('password_errors', [
                    'new_password' => 'New password must be different from the current password.',
                ])
                ->with('error', 'New password must be different from the current password.');
        }

        (new AdminModel())->update((int) $user['id'], [
            'password' => password_hash($newPassword, PASSWORD_BCRYPT),
        ]);

        return redirect()->to(base_url('admin/profile'))
            ->with('active_profile_panel', 'password')
            ->with('success', 'Password updated successfully.');
    }

    private function currentUser(): ?array
    {
        $adminId = session()->get('admin_id');
        if (! $adminId) {
            return null;
        }

        return (new AdminModel())->find((int) $adminId);
    }

    private function refreshAdminSession(array $user): void
    {
        session()->set([
            'admin_id'       => $user['id'],
            'admin_name'     => $user['name'],
            'admin_username' => $user['username'],
            'admin_email'    => $user['email'],
            'admin_phone'    => $user['phone'],
            'admin_photo'    => $user['profile_photo'],
            'admin_usertype' => $user['usertype'],
        ]);
    }

    private function canChangeEmail(array $user): bool
    {
        $nextChangeAt = $this->nextEmailChangeAt($user);

        return $nextChangeAt <= new DateTimeImmutable();
    }

    private function nextEmailChangeAt(array $user): DateTimeImmutable
    {
        if (empty($user['email_changed_at'])) {
            return new DateTimeImmutable('@0');
        }

        return (new DateTimeImmutable($user['email_changed_at']))->modify('+30 days');
    }
}
