<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

class SettingsController extends BaseController
{
    private const DEVELOPER_MODE_OTP_EMAIL = 'aarveyastudio@gmail.com';
    private const DEVELOPER_MODE_OTP_SESSION_KEY = 'developer_mode_otp';
    private const DEVELOPER_MODE_OTP_TTL_SECONDS = 600;

    private function render(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);
        return view('admin/layouts/app', $data);
    }

    public function index(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessSettingsAllowed()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        $this->encryptExistingProtectedSettings($db, Services::appSettings(false));

        $rows = $db->table('settings')->get()->getResultArray();
        $settings = array_column($rows, 'value', 'key');
        $mediaFiles = $db->tableExists('media_files')
            ? (new MediaController())->mediaFiles()
            : [];
        $activeSettingsTab = session()->getFlashdata('active_settings_tab')
            ?? (string) ($this->request->getGet('tab') ?? 'hotel');
        $activeSettingsTab = $activeSettingsTab === 'reservations' ? 'booking' : $activeSettingsTab;

        if ($activeSettingsTab === 'emailtemplates') {
            return redirect()->to(base_url('admin/email-templates'));
        }

        if ($activeSettingsTab === 'receiptstyles') {
            return redirect()->to(base_url('admin/receipt-styles'));
        }

        return $this->render('admin/settings/index', [
            'title'             => 'Settings',
            'page'              => 'settings',
            'settings'          => $settings,
            'mediaFiles'        => $mediaFiles,
            'activeSettingsTab' => $activeSettingsTab,
            'developerOtpPending' => $this->developerModeOtpPending(),
            'developerOtpEmail' => self::DEVELOPER_MODE_OTP_EMAIL,
        ]);
    }

    public function emailTemplates(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessDeveloperSettingsAllowed()) {
            return $redirect;
        }

        return $this->render('admin/developer/email_templates', [
            'title'    => 'Email Templates',
            'page'     => 'emailtemplates',
            'settings' => $this->settingsArray(),
        ]);
    }

    public function receiptStyles(): string|RedirectResponse
    {
        if ($redirect = $this->denyUnlessDeveloperSettingsAllowed()) {
            return $redirect;
        }

        return $this->render('admin/developer/receipt_styles', [
            'title'    => 'Receipt Styles',
            'page'     => 'receiptstyles',
            'settings' => $this->settingsArray(),
        ]);
    }

    public function update()
    {
        if ($redirect = $this->denyUnlessSettingsAllowed()) {
            return $redirect;
        }

        $db       = \Config\Database::connect();
        $settings = Services::appSettings(false);
        $tab      = (string) ($this->request->getPost('settings_tab') ?? 'hotel');
        $beforeValues = $settings->all();

        if (in_array($tab, ['seo', 'emailtemplates', 'receiptstyles'], true) && app_setting('system_developer_mode', '0') !== '1') {
            return redirect()->to(base_url('admin/settings?tab=system'))
                ->with('active_settings_tab', 'system')
                ->with('error', 'Developer Mode must be enabled before advanced settings can be changed.');
        }

        $keysByTab = [
            'hotel' => ['hotel_name', 'hotel_phone', 'hotel_email', 'hotel_address', 'hotel_tagline', 'hotel_whatsapp'],
            'branding' => ['brand_logo', 'brand_favicon', 'brand_header_subtitle', 'brand_footer_text', 'brand_facebook', 'brand_instagram', 'brand_x'],
            'seo' => [
                'seo_meta_title',
                'seo_meta_description',
                'seo_meta_keywords',
                'seo_robots',
                'seo_og_image',
                'seo_twitter_card',
                'seo_home_title',
                'seo_home_description',
                'seo_about_title',
                'seo_about_description',
                'seo_rooms_title',
                'seo_rooms_description',
                'seo_trident_title',
                'seo_trident_description',
                'seo_gallery_title',
                'seo_gallery_description',
                'seo_contact_title',
                'seo_contact_description',
                'seo_faq_title',
                'seo_faq_description',
                'seo_privacy_title',
                'seo_privacy_description',
                'seo_terms_title',
                'seo_terms_description',
                'seo_thank_you_title',
                'seo_thank_you_description',
            ],
            'homepage' => [
                'home_hero_eyebrow',
                'home_hero_title_prefix',
                'home_hero_title_highlight',
                'home_hero_description',
                'home_hero_guest_count',
                'home_hero_review_text',
                'home_hero_image',
                'home_hero_secondary_image',
                'home_stats_rooms',
                'home_stats_staff',
                'home_stats_happy_clients',
                'home_stats_reviews',
                'home_stats_background_image',
                'home_about_eyebrow',
                'home_about_title',
                'home_about_highlight',
                'home_about_description',
                'home_about_mission',
                'home_about_vision',
                'home_about_values',
                'home_about_image',
                'home_about_secondary_image',
                'home_rooms_eyebrow',
                'home_rooms_title',
                'home_rooms_highlight',
                'home_rooms_description',
                'home_offer_eyebrow',
                'home_offer_title',
                'home_offer_highlight',
                'home_offer_description',
                'home_offer_secondary_description',
                'home_offer_image',
                'home_cta_eyebrow',
                'home_cta_title',
                'home_cta_highlight',
                'home_cta_description',
                'home_cta_background_image',
            ],
            'offers' => [
                'home_offer_enabled',
                'home_offer_discount_text',
                'home_offer_type',
            ],
            'aboutpage' => [
                'about_story_image',
                'about_story_secondary_image',
                'about_team_image_1',
                'about_team_image_2',
                'about_team_image_3',
                'about_cta_background_image',
            ],
            'roompage' => [
                'room_detail_about_eyebrow',
                'room_detail_heading_prefix',
                'room_detail_heading_highlight',
                'room_detail_guest_summary_template',
                'room_detail_amenities_label',
                'room_detail_policies_label',
                'room_detail_cancellation_text',
                'room_detail_id_required_text',
            ],
            'tridentpage' => [
                'event_email',
                'trident_hero_eyebrow',
                'trident_hero_title',
                'trident_hero_highlight',
                'trident_overview_eyebrow',
                'trident_overview_title',
                'trident_overview_highlight',
                'trident_overview_description',
                'trident_overview_secondary_description',
                'trident_guest_capacity',
                'trident_venue_area',
                'trident_contact_eyebrow',
                'trident_contact_title',
                'trident_contact_highlight',
                'trident_contact_description',
                'trident_cta_eyebrow',
                'trident_cta_title',
                'trident_cta_highlight',
                'trident_cta_description',
                'trident_guest_ranges',
                'trident_hero_image',
                'trident_secondary_image',
                'trident_features_image',
                'trident_gallery_images',
            ],
            'smtp'  => ['smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_crypto', 'smtp_from_email', 'smtp_from_name'],
            'booking' => [
                'booking_admin_email',
                'booking_whatsapp_number',
                'booking_subject_prefix',
                'booking_auto_reply_enabled',
                'booking_checkin_time',
                'booking_checkout_time',
                'guest_lookup_enabled',
            ],
            'billing' => [
                'receipt_invoice_prefix',
                'receipt_gst_enabled',
                'receipt_gst_rate',
                'receipt_tax_label',
                'receipt_tax_number',
            ],
            'emailtemplates' => [
                'email_template_booking_auto_reply_subject',
                'email_template_booking_auto_reply_body',
                'email_template_event_auto_reply_subject',
                'email_template_event_auto_reply_body',
                'email_template_event_payment_link_subject',
                'email_template_event_payment_link_body',
            ],
            'receiptstyles' => [
                'receipt_pdf_style',
            ],
            'paymentgateway' => [
                'payment_gateway_enabled',
                'payment_gateway_provider',
                'booking_enabled',
                'cashfree_app_id',
                'cashfree_secret_key',
                'cashfree_environment',
                'cashfree_webhook_secret',
                'razorpay_key_id',
                'razorpay_key_secret',
                'razorpay_environment',
                'razorpay_webhook_secret',
            ],
            'legalpage' => ['legal_privacy_hero_image', 'legal_terms_hero_image'],
            'system' => [
                'system_timezone',
                'system_date_format',
                'system_currency_symbol',
                'system_records_per_page',
                'system_maintenance_mode',
                'system_developer_mode',
                'security_login_max_attempts',
                'security_login_lock_minutes',
                'security_refund_otp_max_attempts',
                'security_refund_otp_resend_minutes',
            ],
        ];

        $keys = $keysByTab[$tab] ?? $keysByTab['hotel'];
        $keepWhenBlank = [
            'cashfree_secret_key',
            'cashfree_webhook_secret',
            'razorpay_key_secret',
            'razorpay_webhook_secret',
        ];
        $auditChanges = [];

        if ($tab === 'system' && ! $this->developerModeOtpApproved($beforeValues)) {
            return redirect()->back()
                ->withInput()
                ->with('active_settings_tab', 'system');
        }

        foreach ($keys as $key) {
            $value = $this->request->getPost($key);
            if (in_array($key, $keepWhenBlank, true) && in_array(trim((string) $value), ['', '__KEEP_SECRET__'], true)) {
                continue;
            }

            $this->trackSettingChange($auditChanges, $key, $beforeValues[$key] ?? null, $value, $settings);

            if ($settings->isProtectedKey($key)) {
                $value = $settings->encryptValue(trim((string) $value));
            }

            $exists = $db->table('settings')->where('key', $key)->countAllResults();
            if ($exists) {
                $db->table('settings')->where('key', $key)->update(['value' => $value, 'updated_at' => date('Y-m-d H:i:s')]);
            } else {
                $db->table('settings')->insert(['key' => $key, 'value' => $value, 'updated_at' => date('Y-m-d H:i:s')]);
            }
        }

        $this->encryptExistingProtectedSettings($db, $settings);

        if ($auditChanges !== []) {
            $action = $tab === 'paymentgateway' ? 'payment_config.updated' : 'settings.updated';
            $tabLabel = $this->settingsTabLabel($tab);
            $summary = $tab === 'paymentgateway'
                ? 'Payment gateway settings updated'
                : $tabLabel . ' settings updated';

            Services::auditLogger()->log($action, 'settings', $tab, $summary, [
                'tab' => $tab,
                'changed_keys' => array_keys($auditChanges),
                'changes' => $auditChanges,
            ]);
        }

        return redirect()->back()
            ->with('active_settings_tab', $tab)
            ->with('success', $this->settingsTabLabel($tab) . ' settings saved successfully.');
    }

    private function developerModeOtpApproved(array $beforeValues): bool
    {
        $wasEnabled = (string) ($beforeValues['system_developer_mode'] ?? '0') === '1';
        $wantsEnabled = (string) $this->request->getPost('system_developer_mode') === '1';

        if ($wasEnabled || ! $wantsEnabled) {
            session()->remove(self::DEVELOPER_MODE_OTP_SESSION_KEY);
            return true;
        }

        $otp = preg_replace('/\D+/', '', (string) $this->request->getPost('developer_mode_otp'));
        $otpSession = session()->get(self::DEVELOPER_MODE_OTP_SESSION_KEY);

        if (is_array($otpSession) && time() > (int) ($otpSession['expires_at'] ?? 0)) {
            session()->remove(self::DEVELOPER_MODE_OTP_SESSION_KEY);
            $otpSession = null;
        }

        if ($otp !== '' && is_array($otpSession) && password_verify($otp, (string) ($otpSession['hash'] ?? ''))) {
            session()->remove(self::DEVELOPER_MODE_OTP_SESSION_KEY);

            Services::auditLogger()->log('settings.developer_mode_otp_verified', 'settings', 'system', 'Developer Mode OTP verified', [
                'otp_email' => self::DEVELOPER_MODE_OTP_EMAIL,
            ]);

            return true;
        }

        if ($otp !== '' && is_array($otpSession)) {
            session()->setFlashdata('error', 'Invalid Developer Mode OTP. Please check the code and try again.');
            return false;
        }

        if (is_array($otpSession)) {
            session()->setFlashdata('warning', 'Developer Mode OTP has already been sent to ' . self::DEVELOPER_MODE_OTP_EMAIL . '. Enter the 4-digit code to enable Developer Mode.');
            return false;
        }

        $newOtp = (string) random_int(1000, 9999);

        session()->set(self::DEVELOPER_MODE_OTP_SESSION_KEY, [
            'hash' => password_hash($newOtp, PASSWORD_DEFAULT),
            'email' => self::DEVELOPER_MODE_OTP_EMAIL,
            'expires_at' => time() + self::DEVELOPER_MODE_OTP_TTL_SECONDS,
            'created_at' => time(),
        ]);

        if (! service('appMailer')->sendDeveloperModeOtp(self::DEVELOPER_MODE_OTP_EMAIL, $newOtp)) {
            session()->remove(self::DEVELOPER_MODE_OTP_SESSION_KEY);
            session()->setFlashdata('error', 'Could not send Developer Mode OTP. Please check SMTP settings.');
            return false;
        }

        Services::auditLogger()->log('settings.developer_mode_otp_sent', 'settings', 'system', 'Developer Mode OTP sent', [
            'otp_email' => self::DEVELOPER_MODE_OTP_EMAIL,
        ]);

        session()->setFlashdata('success', 'Developer Mode OTP sent to ' . self::DEVELOPER_MODE_OTP_EMAIL . '. Enter the 4-digit code to enable Developer Mode.');

        return false;
    }

    private function developerModeOtpPending(): bool
    {
        $otpSession = session()->get(self::DEVELOPER_MODE_OTP_SESSION_KEY);

        if (! is_array($otpSession)) {
            return false;
        }

        if (time() > (int) ($otpSession['expires_at'] ?? 0)) {
            session()->remove(self::DEVELOPER_MODE_OTP_SESSION_KEY);
            return false;
        }

        return true;
    }

    private function denyUnlessSettingsAllowed(): ?RedirectResponse
    {
        if (Services::adminPermissions()->can('settings.manage')) {
            return null;
        }

        return redirect()->to(base_url('admin/dashboard'))->with('error', 'You do not have permission to view this page.');
    }

    private function denyUnlessDeveloperSettingsAllowed(): ?RedirectResponse
    {
        if ($redirect = $this->denyUnlessSettingsAllowed()) {
            return $redirect;
        }

        if (app_setting('system_developer_mode', '0') === '1') {
            return null;
        }

        return redirect()->to(base_url('admin/settings?tab=system'))
            ->with('active_settings_tab', 'system')
            ->with('error', 'Developer Mode must be enabled before advanced settings can be opened.');
    }

    private function settingsArray(): array
    {
        $rows = \Config\Database::connect()->table('settings')->get()->getResultArray();

        return array_column($rows, 'value', 'key');
    }

    private function settingsTabLabel(string $tab): string
    {
        return [
            'emailtemplates' => 'Email templates',
            'receiptstyles' => 'Receipt styles',
            'paymentgateway' => 'Payment gateway',
        ][$tab] ?? ucfirst($tab);
    }

    private function trackSettingChange(array &$changes, string $key, mixed $oldValue, mixed $newValue, \App\Libraries\AppSettings $settings): void
    {
        $old = trim((string) ($oldValue ?? ''));
        $new = trim((string) ($newValue ?? ''));

        if ($settings->isProtectedKey($key)) {
            if ($new === '' || $new === '__KEEP_SECRET__') {
                return;
            }

            $changes[$key] = [
                'old' => $old !== '' ? '[configured]' : '[empty]',
                'new' => '[updated]',
            ];

            return;
        }

        if ((string) ($oldValue ?? '') === (string) ($newValue ?? '')) {
            return;
        }

        $changes[$key] = [
            'old' => $this->auditValue($oldValue),
            'new' => $this->auditValue($newValue),
        ];
    }

    private function auditValue(mixed $value): string
    {
        $text = trim((string) ($value ?? ''));

        if (strlen($text) > 180) {
            return substr($text, 0, 177) . '...';
        }

        return $text;
    }

    private function encryptExistingProtectedSettings($db, \App\Libraries\AppSettings $settings): void
    {
        if (! method_exists($db, 'tableExists') || ! $db->tableExists('settings')) {
            return;
        }

        $rows = $db->table('settings')->get()->getResultArray();

        foreach ($rows as $row) {
            $key = (string) ($row['key'] ?? '');
            $value = (string) ($row['value'] ?? '');

            if (! $settings->isProtectedKey($key) || $value === '' || $settings->isEncryptedValue($value)) {
                continue;
            }

            $db->table('settings')->where('key', $key)->update([
                'value'      => $settings->encryptValue($value),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
