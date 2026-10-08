<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

class UserController extends BaseController
{
    private function render(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);

        return view('admin/layouts/app', $data);
    }

    public function index(): string|RedirectResponse
    {
        if (! $this->canManageUsers()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Only owners can manage users.');
        }

        return $this->render('admin/users/index', [
            'title' => 'Users',
            'page' => 'users',
            'users' => (new AdminModel())->orderBy('id', 'ASC')->findAll(),
            'roles' => Services::adminPermissions()->roles(),
        ]);
    }

    public function create(): string|RedirectResponse
    {
        if (! $this->canManageUsers()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Only owners can manage users.');
        }

        return $this->render('admin/users/form', [
            'title' => 'Create User',
            'page' => 'users',
            'user' => null,
            'roles' => Services::adminPermissions()->roles(),
        ]);
    }

    public function permissions(): string|RedirectResponse
    {
        if (! $this->canManageUsers()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Only owners can manage users.');
        }

        $permissions = Services::adminPermissions();

        return $this->render('admin/users/permissions', [
            'title' => 'Permissions',
            'page' => 'users',
            'roles' => $permissions->manageableRoles(),
            'permissionCatalog' => $permissions->permissions(),
            'rolePermissions' => [
                'admin' => $permissions->permissionsForRole('admin'),
                'staff' => $permissions->permissionsForRole('staff'),
            ],
        ]);
    }

    public function updatePermissions(): RedirectResponse
    {
        if (! $this->canManageUsers()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Only owners can manage users.');
        }

        $permissions = Services::adminPermissions();
        $submitted = (array) $this->request->getPost('permissions');

        foreach (array_keys($permissions->manageableRoles()) as $role) {
            $permissions->setPermissionsForRole($role, (array) ($submitted[$role] ?? []));
        }

        Services::auditLogger()->log('permissions.updated', 'role_permissions', null, 'Role permissions updated', [
            'roles' => array_keys($permissions->manageableRoles()),
        ]);

        return redirect()->to(base_url('admin/users/permissions'))->with('success', 'Permissions updated.');
    }

    public function store(): RedirectResponse
    {
        if (! $this->canManageUsers()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Only owners can manage users.');
        }

        if (! $this->validate($this->rules(true))) {
            return redirect()->to(base_url('admin/users/create'))->withInput()->with('error', $this->validationErrorMessage());
        }

        $role = $this->validRole((string) $this->request->getPost('usertype'));
        $model = new AdminModel();
        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'username' => trim((string) $this->request->getPost('username')),
            'email' => trim((string) $this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'usertype' => $role,
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_BCRYPT),
        ];
        $model->insert($data);

        Services::auditLogger()->log('user.created', 'user', $model->getInsertID(), 'User created: ' . $data['email'], [
            'role' => $role,
        ]);

        return redirect()->to(base_url('admin/users'))->with('success', 'User created.');
    }

    public function edit(int $id): string|RedirectResponse
    {
        if (! $this->canManageUsers()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Only owners can manage users.');
        }

        $user = (new AdminModel())->find($id);

        if (! $user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User not found.');
        }

        return $this->render('admin/users/form', [
            'title' => 'Edit User',
            'page' => 'users',
            'user' => $user,
            'roles' => Services::adminPermissions()->roles(),
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        if (! $this->canManageUsers()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Only owners can manage users.');
        }

        $model = new AdminModel();
        $user = $model->find($id);

        if (! $user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User not found.');
        }

        if (! $this->validate($this->rules(false, $id))) {
            return redirect()->to(base_url('admin/users/' . $id . '/edit'))->withInput()->with('error', $this->validationErrorMessage());
        }

        $role = $this->validRole((string) $this->request->getPost('usertype'));

        if ((int) session()->get('admin_id') === $id && $role !== 'owner') {
            return redirect()->to(base_url('admin/users/' . $id . '/edit'))->withInput()->with('error', 'You cannot remove owner access from your own account.');
        }

        $ownerCount = $model->where('usertype', 'owner')->countAllResults();

        if (($user['usertype'] ?? '') === 'owner' && $role !== 'owner' && $ownerCount <= 1) {
            return redirect()->to(base_url('admin/users/' . $id . '/edit'))->withInput()->with('error', 'At least one owner account is required.');
        }

        $data = [
            'name' => trim((string) $this->request->getPost('name')),
            'username' => trim((string) $this->request->getPost('username')),
            'email' => trim((string) $this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'usertype' => $role,
        ];
        $model->update($id, $data);

        if ((int) session()->get('admin_id') === $id) {
            session()->set([
                'admin_name' => $data['name'],
                'admin_username' => $data['username'],
                'admin_email' => $data['email'],
                'admin_phone' => $data['phone'],
                'admin_usertype' => $role,
            ]);
        }

        Services::auditLogger()->log('user.updated', 'user', $id, 'User updated: ' . $data['email'], [
            'old_role' => (string) ($user['usertype'] ?? ''),
            'new_role' => $role,
        ]);

        return redirect()->to(base_url('admin/users'))->with('success', 'User updated.');
    }

    public function password(int $id): RedirectResponse
    {
        if (! $this->canManageUsers()) {
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'Only owners can manage users.');
        }

        $password = (string) $this->request->getPost('password');

        if (strlen($password) < 8) {
            return redirect()->to(base_url('admin/users/' . $id . '/edit'))->with('error', 'Password must be at least 8 characters.');
        }

        $model = new AdminModel();
        $user = $model->find($id);

        if (! $user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User not found.');
        }

        $model->update($id, ['password' => password_hash($password, PASSWORD_BCRYPT)]);
        Services::auditLogger()->log('user.password_updated', 'user', $id, 'User password updated: ' . (string) ($user['email'] ?? ''));

        return redirect()->to(base_url('admin/users/' . $id . '/edit'))->with('success', 'Password updated.');
    }

    private function rules(bool $creating, ?int $id = null): array
    {
        $usernameUnique = $creating ? 'is_unique[users.username]' : 'is_unique[users.username,id,' . $id . ']';
        $emailUnique = $creating ? 'is_unique[users.email]' : 'is_unique[users.email,id,' . $id . ']';

        return [
            'name' => 'required|min_length[3]|max_length[120]',
            'username' => 'required|min_length[3]|max_length[80]|' . $usernameUnique,
            'email' => 'required|valid_email|max_length[180]|' . $emailUnique,
            'phone' => 'permit_empty|max_length[20]',
            'usertype' => 'required|in_list[owner,admin,staff]',
            'password' => $creating ? 'required|min_length[8]' : 'permit_empty',
        ];
    }

    private function validRole(string $role): string
    {
        return array_key_exists($role, Services::adminPermissions()->roles()) ? $role : 'staff';
    }

    private function validationErrorMessage(): string
    {
        $errors = $this->validator?->getErrors() ?? [];

        if ($errors === []) {
            return 'Please correct the highlighted fields.';
        }

        return implode(' ', array_values($errors));
    }

    private function canManageUsers(): bool
    {
        return Services::adminPermissions()->can('users.manage');
    }
}
