<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AuthController extends BaseController
{
    // ── Show login form ──────────────────────────────────────────────────────
    public function loginForm()
    {
        // Already logged in → redirect to dashboard
        if (session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/dashboard'));
        }

        return view('admin/auth/login');
    }

    // ── Handle login POST ────────────────────────────────────────────────────
    public function loginPost()
    {
        $login    = trim((string) $this->request->getPost('login'));
        $password = $this->request->getPost('password');
        $rateIdentifier = $this->loginRateIdentifier($login);
        $rateLimiter = service('rateLimiter');

        if ($rateLimiter->isLocked('admin_login', $rateIdentifier)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $rateLimiter->lockedMessage('admin_login', $rateIdentifier, 'Too many failed login attempts.'));
        }

        // Validate input
        if (! $this->validate([
            'login'    => 'required',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Please enter your username/email and password.');
        }

        // Load admin model
        $adminModel = new \App\Models\AdminModel();
        $admin      = $adminModel
            ->groupStart()
                ->where('email', $login)
                ->orWhere('username', $login)
            ->groupEnd()
            ->whereIn('usertype', ['owner', 'admin', 'staff'])
            ->first();

        if (! $admin || ! password_verify($password, $admin['password'])) {
            $rateLimiter->hit(
                'admin_login',
                $rateIdentifier,
                (int) app_setting('security_login_max_attempts', '5'),
                (int) app_setting('security_login_lock_minutes', '15')
            );

            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email or password. Please try again.');
        }

        $rateLimiter->clear('admin_login', $rateIdentifier);

        $adminModel->update((int) $admin['id'], [
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $this->request->getIPAddress(),
        ]);

        session()->regenerate(true);

        // Set session
        session()->set([
            'admin_logged_in' => true,
            'admin_id'        => $admin['id'],
            'admin_name'      => $admin['name'],
            'admin_username'  => $admin['username'],
            'admin_email'     => $admin['email'],
            'admin_phone'     => $admin['phone'],
            'admin_photo'     => $admin['profile_photo'],
            'admin_usertype'  => $admin['usertype'],
        ]);

        return redirect()->to(base_url('admin/dashboard'))
            ->with('success', 'Welcome back, ' . $admin['name'] . '!');
    }

    // ── Logout ───────────────────────────────────────────────────────────────
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('admin/login'))
            ->with('success', 'You have been logged out successfully.');
    }

    private function loginRateIdentifier(string $login): string
    {
        $login = strtolower(trim($login));
        $ip = (string) $this->request->getIPAddress();

        return hash('sha256', ($login !== '' ? $login : 'blank') . '|' . $ip);
    }
}
