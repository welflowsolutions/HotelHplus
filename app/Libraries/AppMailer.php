<?php

namespace App\Libraries;

use Config\Services;

class AppMailer
{
    public function createEmail(): \CodeIgniter\Email\Email
    {
        $settings = Services::appSettings();

        $config = [
            'protocol'   => $settings->get('smtp_host') ? 'smtp' : 'mail',
            'SMTPHost'   => (string) $settings->get('smtp_host', ''),
            'SMTPUser'   => (string) $settings->get('smtp_user', ''),
            'SMTPPass'   => (string) $settings->get('smtp_pass', ''),
            'SMTPPort'   => (int) $settings->get('smtp_port', 587),
            'SMTPCrypto' => (string) $settings->get('smtp_crypto', 'tls'),
            'mailType'   => 'html',
            'charset'    => 'UTF-8',
            'newline'    => "\r\n",
            'CRLF'       => "\r\n",
        ];

        $email = Services::email($config, false);
        $email->initialize($config);
        $email->setFrom(
            (string) $settings->get('smtp_from_email', $settings->get('hotel_email', 'no-reply@example.com')),
            (string) $settings->get('smtp_from_name', $settings->get('hotel_name', 'Hotel'))
        );

        return $email;
    }

    public function sendEnquiryAdminNotification(array $enquiry): bool
    {
        $settings   = Services::appSettings();
        $hotelName  = (string) $settings->get('hotel_name', 'Hotel H Plus');
        $adminEmail = (string) $settings->get('booking_admin_email', $settings->get('hotel_email', ''));
        $prefix     = trim((string) $settings->get('booking_subject_prefix', '[' . $hotelName . ']'));

        if ($adminEmail === '') {
            return false;
        }

        $email = $this->createEmail();
        $email->setTo($adminEmail);
        $email->setReplyTo((string) ($enquiry['email'] ?? ''), trim((string) (($enquiry['first_name'] ?? '') . ' ' . ($enquiry['last_name'] ?? ''))));
        $email->setSubject(trim($prefix . ' New enquiry from ' . ($enquiry['first_name'] ?? 'Guest')));
        $email->setMessage($this->adminEnquiryMessage($enquiry, $hotelName));

        return $email->send();
    }

    public function sendEnquiryAutoReply(array $enquiry): bool
    {
        $settings = Services::appSettings();

        if ((string) $settings->get('booking_auto_reply_enabled', '1') !== '1') {
            return false;
        }

        $guestEmail = (string) ($enquiry['email'] ?? '');
        if ($guestEmail === '') {
            return false;
        }

        $hotelName = (string) $settings->get('hotel_name', 'Hotel H Plus');
        $email     = $this->createEmail();
        $email->setTo($guestEmail);
        $email->setSubject($hotelName . ' enquiry received');
        $email->setMessage($this->guestReplyMessage($enquiry, $settings->all()));

        return $email->send();
    }

    public function sendBookingAdminNotification(array $booking): bool
    {
        $settings   = Services::appSettings();
        $hotelName  = (string) $settings->get('hotel_name', 'Hotel H Plus');
        $adminEmail = (string) $settings->get('booking_admin_email', $settings->get('hotel_email', ''));
        $prefix     = trim((string) $settings->get('booking_subject_prefix', '[' . $hotelName . ']'));

        if ($adminEmail === '') {
            return false;
        }

        $email = $this->createEmail();
        $email->setTo($adminEmail);

        $guestEmail = trim((string) ($booking['email'] ?? ''));
        if ($guestEmail !== '') {
            $email->setReplyTo($guestEmail, trim((string) ($booking['name'] ?? 'Guest')));
        }

        $email->setSubject(trim($prefix . ' New booking request from ' . ($booking['name'] ?? 'Guest')));
        $email->setMessage($this->adminBookingMessage($booking, $hotelName));

        return $email->send();
    }

    public function sendBookingAutoReply(array $booking): bool
    {
        $settings = Services::appSettings();

        if ((string) $settings->get('booking_auto_reply_enabled', '1') !== '1') {
            return false;
        }

        $guestEmail = trim((string) ($booking['email'] ?? ''));
        if ($guestEmail === '') {
            return false;
        }

        $hotelName = (string) $settings->get('hotel_name', 'Hotel H Plus');
        $variables = $this->bookingTemplateVariables($booking, $settings->all());
        $subject = $this->renderTemplate(
            (string) $settings->get('email_template_booking_auto_reply_subject', $hotelName . ' booking request received'),
            $variables
        );
        $message = $this->renderTemplate(
            (string) $settings->get('email_template_booking_auto_reply_body', ''),
            $variables,
            true
        ) ?: $this->guestBookingReplyMessage($booking, $settings->all());

        $email     = $this->createEmail();
        $email->setTo($guestEmail);
        $email->setSubject($subject ?: $hotelName . ' booking request received');
        $email->setMessage($message);

        return $email->send();
    }

    public function sendTridentAdminNotification(array $enquiry): bool
    {
        $settings   = Services::appSettings();
        $hotelName  = (string) $settings->get('hotel_name', 'Hotel H Plus');
        $adminEmail = (string) $settings->get('event_email', $settings->get('hotel_email', ''));
        $prefix     = trim((string) $settings->get('booking_subject_prefix', '[' . $hotelName . ']'));

        if ($adminEmail === '') {
            return false;
        }

        $email = $this->createEmail();
        $email->setTo($adminEmail);

        $guestEmail = trim((string) ($enquiry['email'] ?? ''));
        if ($guestEmail !== '') {
            $email->setReplyTo($guestEmail, trim((string) ($enquiry['name'] ?? 'Guest')));
        }

        $email->setSubject(trim($prefix . ' New Trident enquiry from ' . ($enquiry['name'] ?? 'Guest')));
        $email->setMessage($this->adminTridentMessage($enquiry, $hotelName));

        return $email->send();
    }

    public function sendTridentAutoReply(array $enquiry): bool
    {
        $settings = Services::appSettings();

        if ((string) $settings->get('booking_auto_reply_enabled', '1') !== '1') {
            return false;
        }

        $guestEmail = trim((string) ($enquiry['email'] ?? ''));
        if ($guestEmail === '') {
            return false;
        }

        $hotelName = (string) $settings->get('hotel_name', 'Hotel H Plus');
        $email     = $this->createEmail();
        $email->setTo($guestEmail);
        $email->setSubject($hotelName . ' event enquiry received');
        $email->setMessage($this->guestTridentReplyMessage($enquiry, $settings->all()));

        return $email->send();
    }

    public function sendEventAdminNotification(array $enquiry): bool
    {
        $settings   = Services::appSettings();
        $hotelName  = (string) $settings->get('hotel_name', 'Hotel H Plus');
        $adminEmail = (string) $settings->get('events_email', $settings->get('hotel_email', ''));
        $prefix     = trim((string) $settings->get('booking_subject_prefix', '[' . $hotelName . ']'));

        if ($adminEmail === '') {
            return false;
        }

        $email = $this->createEmail();
        $email->setTo($adminEmail);

        $guestEmail = trim((string) ($enquiry['email'] ?? ''));
        if ($guestEmail !== '') {
            $email->setReplyTo($guestEmail, trim((string) ($enquiry['name'] ?? 'Guest')));
        }

        $email->setSubject(trim($prefix . ' New event enquiry from ' . ($enquiry['name'] ?? 'Guest')));
        $email->setMessage($this->adminEventMessage($enquiry, $hotelName));

        return $email->send();
    }

    public function sendEventAutoReply(array $enquiry): bool
    {
        $settings = Services::appSettings();

        if ((string) $settings->get('booking_auto_reply_enabled', '1') !== '1') {
            return false;
        }

        $guestEmail = trim((string) ($enquiry['email'] ?? ''));
        if ($guestEmail === '') {
            return false;
        }

        $hotelName = (string) $settings->get('hotel_name', 'Hotel H Plus');
        $variables = $this->eventTemplateVariables($enquiry, $settings->all());
        $subject = $this->renderTemplate(
            (string) $settings->get('email_template_event_auto_reply_subject', $hotelName . ' event enquiry received'),
            $variables
        );
        $message = $this->renderTemplate(
            (string) $settings->get('email_template_event_auto_reply_body', ''),
            $variables,
            true
        ) ?: $this->guestEventReplyMessage($enquiry, $settings->all());

        $email     = $this->createEmail();
        $email->setTo($guestEmail);
        $email->setSubject($subject ?: $hotelName . ' event enquiry received');
        $email->setMessage($message);

        return $email->send();
    }

    public function sendSubscriberWelcome(array $subscriber): bool
    {
        $guestEmail = trim((string) ($subscriber['email'] ?? ''));
        if ($guestEmail === '') {
            return false;
        }

        $settings  = Services::appSettings();
        $hotelName = (string) $settings->get('hotel_name', 'Hotel H Plus');

        $email = $this->createEmail();
        $email->setTo($guestEmail);
        $email->setSubject('Welcome to ' . $hotelName);
        $email->setMessage($this->subscriberWelcomeMessage($subscriber, $settings->all()));

        return $email->send();
    }

    public function sendAdminRefundOtp(string $adminEmail, string $otp, array $transaction): bool
    {
        $adminEmail = trim($adminEmail);

        if ($adminEmail === '') {
            return false;
        }

        $settings = Services::appSettings();
        $hotelName = (string) $settings->get('hotel_name', 'Hotel H Plus');
        $amount = (string) ($transaction['currency'] ?? 'INR') . ' ' . number_format((float) ($transaction['amount'] ?? 0), 2);
        $bookingCode = (string) ($transaction['booking_code'] ?? '—');

        $email = $this->createEmail();
        $email->setTo($adminEmail);
        $email->setSubject($hotelName . ' refund verification OTP');
        $email->setMessage(
            '<h2>Refund verification</h2>'
            . '<p>Use this OTP to approve a refund request in the admin panel.</p>'
            . '<p style="font-size:28px;letter-spacing:6px;font-weight:700;margin:18px 0;">' . esc($otp) . '</p>'
            . '<p><strong>Booking:</strong> ' . esc($bookingCode) . '</p>'
            . '<p><strong>Amount:</strong> ' . esc($amount) . '</p>'
            . '<p><strong>Gateway:</strong> ' . esc(ucfirst((string) ($transaction['gateway'] ?? ''))) . '</p>'
            . '<p>This OTP expires in 10 minutes. If you did not request this refund, do not share this code.</p>'
        );

        return $email->send();
    }

    public function sendDeveloperModeOtp(string $developerEmail, string $otp): bool
    {
        $developerEmail = trim($developerEmail);

        if ($developerEmail === '') {
            return false;
        }

        $settings = Services::appSettings();
        $hotelName = (string) $settings->get('hotel_name', 'Hotel H Plus');

        $email = $this->createEmail();
        $email->setTo($developerEmail);
        $email->setSubject($hotelName . ' Developer Mode OTP');
        $email->setMessage(
            '<h2>Developer Mode verification</h2>'
            . '<p>Use this OTP to enable Developer Mode in the admin panel.</p>'
            . '<p style="font-size:28px;letter-spacing:6px;font-weight:700;margin:18px 0;">' . esc($otp) . '</p>'
            . '<p>This OTP expires in 10 minutes. If you did not request Developer Mode, do not share this code.</p>'
        );

        return $email->send();
    }

    public function sendGuestRefundNotification(array $booking, array $refund): bool
    {
        $guestEmail = trim((string) ($booking['email'] ?? ''));

        if ($guestEmail === '') {
            return false;
        }

        $settings = Services::appSettings();
        $hotelName = (string) $settings->get('hotel_name', 'Hotel H Plus');
        $amount = (string) ($refund['currency'] ?? ($booking['currency'] ?? 'INR')) . ' ' . number_format((float) ($refund['amount'] ?? $booking['total_amount'] ?? 0), 2);
        $refundReference = (string) ($refund['refund_reference'] ?? '');

        $email = $this->createEmail();
        $email->setTo($guestEmail);
        $email->setSubject($hotelName . ' refund processed');
        $email->setMessage(
            '<h2>Refund processed</h2>'
            . '<p>Hello ' . esc((string) ($booking['name'] ?? 'Guest')) . ',</p>'
            . '<p>Your refund for booking <strong>' . esc((string) ($booking['booking_code'] ?? '')) . '</strong> has been processed.</p>'
            . '<p><strong>Refund amount:</strong> ' . esc($amount) . '</p>'
            . '<p><strong>Refund reference:</strong> ' . esc($refundReference) . '</p>'
            . '<p>The final bank/card settlement timeline depends on your payment provider and issuing bank.</p>'
            . '<p>Regards,<br>' . esc($hotelName) . '</p>'
        );

        return $email->send();
    }

    public function sendEventPaymentLink(array $payment, string $paymentLink): bool
    {
        $guestEmail = trim((string) ($payment['customer_email'] ?? ''));

        if ($guestEmail === '') {
            return false;
        }

        $settings = Services::appSettings();
        $hotelName = (string) $settings->get('hotel_name', 'Hotel H Plus');
        $amount = (string) ($payment['currency'] ?? 'INR') . ' ' . number_format((float) ($payment['amount'] ?? 0), 2);
        $variables = $this->eventPaymentTemplateVariables($payment, $settings->all(), $paymentLink, $amount);
        $subject = $this->renderTemplate(
            (string) $settings->get('email_template_event_payment_link_subject', $hotelName . ' event payment link'),
            $variables
        );
        $message = $this->renderTemplate(
            (string) $settings->get('email_template_event_payment_link_body', ''),
            $variables,
            true
        ) ?: $this->eventPaymentLinkMessage($payment, $paymentLink, $hotelName, $amount);

        $email = $this->createEmail();
        $email->setTo($guestEmail);
        $email->setSubject($subject ?: $hotelName . ' event payment link');
        $email->setMessage($message);

        return $email->send();
    }

    private function adminEnquiryMessage(array $enquiry, string $hotelName): string
    {
        $fullName = trim((string) (($enquiry['first_name'] ?? '') . ' ' . ($enquiry['last_name'] ?? '')));

        return '<h2>New enquiry received</h2>'
            . '<p><strong>Hotel:</strong> ' . esc($hotelName) . '</p>'
            . '<p><strong>Name:</strong> ' . esc($fullName) . '</p>'
            . '<p><strong>Email:</strong> ' . esc((string) ($enquiry['email'] ?? '')) . '</p>'
            . '<p><strong>Phone:</strong> ' . esc((string) ($enquiry['phone'] ?? '')) . '</p>'
            . '<p><strong>Subject:</strong> ' . esc((string) ($enquiry['subject'] ?? '')) . '</p>'
            . '<p><strong>Room Type:</strong> ' . esc((string) ($enquiry['room_type'] ?? '')) . '</p>'
            . '<p><strong>Check-in:</strong> ' . esc((string) ($enquiry['checkin'] ?? '')) . '</p>'
            . '<p><strong>Check-out:</strong> ' . esc((string) ($enquiry['checkout'] ?? '')) . '</p>'
            . '<p><strong>Message:</strong></p>'
            . '<p>' . nl2br(esc((string) ($enquiry['message'] ?? ''))) . '</p>';
    }

    private function guestReplyMessage(array $enquiry, array $settings): string
    {
        $hotelName = (string) ($settings['hotel_name'] ?? 'Hotel H Plus');
        $phone     = (string) ($settings['hotel_phone'] ?? '');
        $email     = (string) ($settings['hotel_email'] ?? '');
        $name      = trim((string) (($enquiry['first_name'] ?? '') . ' ' . ($enquiry['last_name'] ?? 'Guest')));

        return '<p>Hello ' . esc($name) . ',</p>'
            . '<p>Thank you for contacting ' . esc($hotelName) . '. We have received your enquiry and our team will get back to you shortly.</p>'
            . '<p><strong>Your subject:</strong> ' . esc((string) ($enquiry['subject'] ?? '')) . '</p>'
            . '<p>If needed, you can also reach us directly at ' . esc($phone ?: $email) . '.</p>'
            . '<p>Regards,<br>' . esc($hotelName) . '</p>';
    }

    private function adminBookingMessage(array $booking, string $hotelName): string
    {
        return '<h2>New booking request received</h2>'
            . '<p><strong>Hotel:</strong> ' . esc($hotelName) . '</p>'
            . '<p><strong>Name:</strong> ' . esc((string) ($booking['name'] ?? '')) . '</p>'
            . '<p><strong>Email:</strong> ' . esc((string) ($booking['email'] ?? '')) . '</p>'
            . '<p><strong>Phone:</strong> ' . esc((string) ($booking['phone'] ?? '')) . '</p>'
            . '<p><strong>Room Type:</strong> ' . esc((string) ($booking['room_type'] ?? '')) . '</p>'
            . '<p><strong>Check-in:</strong> ' . esc((string) ($booking['checkin'] ?? '')) . '</p>'
            . '<p><strong>Check-out:</strong> ' . esc((string) ($booking['checkout'] ?? '')) . '</p>'
            . '<p><strong>Rooms Required:</strong> ' . esc((string) ($booking['rooms_required'] ?? '1')) . '</p>'
            . '<p><strong>Guests:</strong> ' . esc((string) ($booking['guests'] ?? '')) . '</p>'
            . '<p><strong>Notes:</strong></p>'
            . '<p>' . nl2br(esc((string) ($booking['notes'] ?? ''))) . '</p>';
    }

    private function guestBookingReplyMessage(array $booking, array $settings): string
    {
        $hotelName = (string) ($settings['hotel_name'] ?? 'Hotel H Plus');
        $phone     = (string) ($settings['hotel_phone'] ?? '');
        $email     = (string) ($settings['hotel_email'] ?? '');
        $name      = trim((string) ($booking['name'] ?? 'Guest'));

        return '<p>Hello ' . esc($name) . ',</p>'
            . '<p>Thank you for your booking request at ' . esc($hotelName) . '. We have received your request and our team will confirm availability shortly.</p>'
            . '<p><strong>Room Type:</strong> ' . esc((string) ($booking['room_type'] ?? '')) . '</p>'
            . '<p><strong>Stay Dates:</strong> ' . esc((string) ($booking['checkin'] ?? '')) . ' to ' . esc((string) ($booking['checkout'] ?? '')) . '</p>'
            . '<p><strong>Rooms Required:</strong> ' . esc((string) ($booking['rooms_required'] ?? '1')) . '</p>'
            . '<p><strong>Guests:</strong> ' . esc((string) ($booking['guests'] ?? '')) . '</p>'
            . '<p>If needed, you can also reach us directly at ' . esc($phone ?: $email) . '.</p>'
            . '<p>Regards,<br>' . esc($hotelName) . '</p>';
    }

    private function adminTridentMessage(array $enquiry, string $hotelName): string
    {
        return '<h2>New Trident event enquiry received</h2>'
            . '<p><strong>Hotel:</strong> ' . esc($hotelName) . '</p>'
            . '<p><strong>Name:</strong> ' . esc((string) ($enquiry['name'] ?? '')) . '</p>'
            . '<p><strong>Email:</strong> ' . esc((string) ($enquiry['email'] ?? '')) . '</p>'
            . '<p><strong>Phone:</strong> ' . esc((string) ($enquiry['phone'] ?? '')) . '</p>'
            . '<p><strong>Event Type:</strong> ' . esc((string) ($enquiry['event_type'] ?? '')) . '</p>'
            . '<p><strong>Event Date:</strong> ' . esc((string) ($enquiry['event_date'] ?? '')) . '</p>'
            . '<p><strong>Guests:</strong> ' . esc((string) ($enquiry['guests'] ?? '')) . '</p>'
            . '<p><strong>Message:</strong></p>'
            . '<p>' . nl2br(esc((string) ($enquiry['message'] ?? ''))) . '</p>';
    }

    private function guestTridentReplyMessage(array $enquiry, array $settings): string
    {
        $hotelName = (string) ($settings['hotel_name'] ?? 'Hotel H Plus');
        $phone     = (string) ($settings['hotel_phone'] ?? '');
        $email     = (string) ($settings['event_email'] ?? ($settings['hotel_email'] ?? ''));
        $name      = trim((string) ($enquiry['name'] ?? 'Guest'));

        return '<p>Hello ' . esc($name) . ',</p>'
            . '<p>Thank you for your Trident event enquiry at ' . esc($hotelName) . '. We have received your request and our events team will get back to you shortly.</p>'
            . '<p><strong>Event Type:</strong> ' . esc((string) ($enquiry['event_type'] ?? '')) . '</p>'
            . '<p><strong>Event Date:</strong> ' . esc((string) ($enquiry['event_date'] ?? '')) . '</p>'
            . '<p><strong>Guests:</strong> ' . esc((string) ($enquiry['guests'] ?? '')) . '</p>'
            . '<p>If needed, you can also reach us directly at ' . esc($phone ?: $email) . '.</p>'
            . '<p>Regards,<br>' . esc($hotelName) . '</p>';
    }

    private function adminEventMessage(array $enquiry, string $hotelName): string
    {
        return '<h2>New event enquiry received</h2>'
            . '<p><strong>Hotel:</strong> ' . esc($hotelName) . '</p>'
            . '<p><strong>Name:</strong> ' . esc((string) ($enquiry['name'] ?? '')) . '</p>'
            . '<p><strong>Email:</strong> ' . esc((string) ($enquiry['email'] ?? '')) . '</p>'
            . '<p><strong>Phone:</strong> ' . esc((string) ($enquiry['phone'] ?? '')) . '</p>'
            . '<p><strong>Event Type:</strong> ' . esc((string) ($enquiry['event_type'] ?? '')) . '</p>'
            . '<p><strong>Event Date:</strong> ' . esc((string) ($enquiry['event_date'] ?? '')) . '</p>'
            . '<p><strong>Guests:</strong> ' . esc((string) ($enquiry['guests'] ?? '')) . '</p>'
            . '<p><strong>Message:</strong></p>'
            . '<p>' . nl2br(esc((string) ($enquiry['message'] ?? ''))) . '</p>';
    }

    private function guestEventReplyMessage(array $enquiry, array $settings): string
    {
        $hotelName = (string) ($settings['hotel_name'] ?? 'Hotel H Plus');
        $phone     = (string) ($settings['hotel_phone'] ?? '');
        $email     = (string) ($settings['events_email'] ?? ($settings['hotel_email'] ?? ''));
        $name      = trim((string) ($enquiry['name'] ?? 'Guest'));

        return '<p>Hello ' . esc($name) . ',</p>'
            . '<p>Thank you for your event enquiry at ' . esc($hotelName) . '. We have received your request and our team will get back to you shortly.</p>'
            . '<p><strong>Event Type:</strong> ' . esc((string) ($enquiry['event_type'] ?? '')) . '</p>'
            . '<p><strong>Event Date:</strong> ' . esc((string) ($enquiry['event_date'] ?? '')) . '</p>'
            . '<p><strong>Guests:</strong> ' . esc((string) ($enquiry['guests'] ?? '')) . '</p>'
            . '<p>If needed, you can also reach us directly at ' . esc($phone ?: $email) . '.</p>'
            . '<p>Regards,<br>' . esc($hotelName) . '</p>';
    }

    private function eventPaymentLinkMessage(array $payment, string $paymentLink, string $hotelName, string $amount): string
    {
        return '<p>Hello ' . esc((string) ($payment['customer_name'] ?? 'Guest')) . ',</p>'
            . '<p>Your event payment link from ' . esc($hotelName) . ' is ready.</p>'
            . '<p><strong>Payment Code:</strong> ' . esc((string) ($payment['payment_code'] ?? '')) . '</p>'
            . '<p><strong>Event:</strong> ' . esc((string) ($payment['event_type'] ?? 'Event')) . '</p>'
            . '<p><strong>Event Date:</strong> ' . esc((string) ($payment['event_date'] ?? '')) . '</p>'
            . '<p><strong>Amount:</strong> ' . esc($amount) . '</p>'
            . '<p><a href="' . esc($paymentLink, 'attr') . '" style="display:inline-block;padding:12px 18px;background:#c99a30;color:#111827;text-decoration:none;font-weight:700;">Pay Securely</a></p>'
            . '<p>If the button does not open, use this link:<br>' . esc($paymentLink) . '</p>'
            . '<p>Regards,<br>' . esc($hotelName) . '</p>';
    }

    private function bookingTemplateVariables(array $booking, array $settings): array
    {
        $hotelName = (string) ($settings['hotel_name'] ?? 'Hotel H Plus');
        $phone = (string) ($settings['hotel_phone'] ?? '');
        $email = (string) ($settings['hotel_email'] ?? '');

        return [
            'hotel_name' => $hotelName,
            'hotel_phone' => $phone,
            'hotel_email' => $email,
            'hotel_contact' => $phone !== '' ? $phone : $email,
            'guest_name' => (string) ($booking['name'] ?? 'Guest'),
            'guest_email' => (string) ($booking['email'] ?? ''),
            'guest_phone' => (string) ($booking['phone'] ?? ''),
            'booking_code' => (string) ($booking['booking_code'] ?? ''),
            'room_name' => (string) ($booking['room_type'] ?? $booking['room_name'] ?? ''),
            'checkin' => (string) ($booking['checkin'] ?? ''),
            'checkout' => (string) ($booking['checkout'] ?? ''),
            'rooms_required' => (string) ($booking['rooms_required'] ?? '1'),
            'guests' => (string) ($booking['guests'] ?? ''),
            'payment_status' => (string) ($booking['payment_status'] ?? ''),
        ];
    }

    private function eventTemplateVariables(array $enquiry, array $settings): array
    {
        $hotelName = (string) ($settings['hotel_name'] ?? 'Hotel H Plus');
        $phone = (string) ($settings['hotel_phone'] ?? '');
        $email = (string) ($settings['events_email'] ?? ($settings['event_email'] ?? ($settings['hotel_email'] ?? '')));

        return [
            'hotel_name' => $hotelName,
            'hotel_phone' => $phone,
            'hotel_email' => $email,
            'hotel_contact' => $phone !== '' ? $phone : $email,
            'guest_name' => (string) ($enquiry['name'] ?? 'Guest'),
            'guest_email' => (string) ($enquiry['email'] ?? ''),
            'guest_phone' => (string) ($enquiry['phone'] ?? ''),
            'event_type' => (string) ($enquiry['event_type'] ?? 'Event'),
            'event_date' => (string) ($enquiry['event_date'] ?? ''),
            'guests' => (string) ($enquiry['guests'] ?? ''),
            'message' => (string) ($enquiry['message'] ?? ''),
        ];
    }

    private function eventPaymentTemplateVariables(array $payment, array $settings, string $paymentLink, string $amount): array
    {
        $variables = $this->eventTemplateVariables([
            'name' => $payment['customer_name'] ?? 'Guest',
            'email' => $payment['customer_email'] ?? '',
            'phone' => $payment['customer_phone'] ?? '',
            'event_type' => $payment['event_type'] ?? 'Event',
            'event_date' => $payment['event_date'] ?? '',
            'guests' => $payment['guests'] ?? '',
        ], $settings);

        $variables['payment_code'] = (string) ($payment['payment_code'] ?? '');
        $variables['amount'] = $amount;
        $variables['payment_link'] = $paymentLink;

        return $variables;
    }

    private function renderTemplate(string $template, array $variables, bool $html = false): string
    {
        $template = trim($template);
        if ($template === '') {
            return '';
        }

        $replacements = [];
        foreach ($variables as $key => $value) {
            if ($html && $key === 'payment_link' && trim((string) $value) !== '') {
                $safeUrl = esc((string) $value, 'attr');
                $replacements['{' . $key . '}'] = '<a href="' . $safeUrl . '">' . esc((string) $value) . '</a>';
                continue;
            }

            $replacements['{' . $key . '}'] = $html ? esc((string) $value) : (string) $value;
        }

        $rendered = strtr($template, $replacements);

        return $html ? '<p>' . str_replace(["\r\n", "\r", "\n"], "</p>\n<p>", $rendered) . '</p>' : $rendered;
    }

    private function subscriberWelcomeMessage(array $subscriber, array $settings): string
    {
        $hotelName = (string) ($settings['hotel_name'] ?? 'Hotel H Plus');
        $phone     = (string) ($settings['hotel_phone'] ?? '');
        $email     = (string) ($settings['hotel_email'] ?? '');
        $name      = trim((string) ($subscriber['full_name'] ?? 'Guest'));

        return '<p>Hello ' . esc($name) . ',</p>'
            . '<p>Thank you for subscribing to ' . esc($hotelName) . '.</p>'
            . '<p>You will now receive updates, offers, and hospitality news from our team.</p>'
            . '<p>If you need anything sooner, you can reach us directly at ' . esc($phone ?: $email) . '.</p>'
            . '<p>Warm regards,<br>' . esc($hotelName) . '</p>';
    }
}
