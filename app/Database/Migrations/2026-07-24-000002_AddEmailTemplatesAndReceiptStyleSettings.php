<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailTemplatesAndReceiptStyleSettings extends Migration
{
    public function up()
    {
        $settings = [
            'receipt_pdf_style' => 'classic',
            'email_template_booking_auto_reply_subject' => 'Your booking request at {hotel_name}',
            'email_template_booking_auto_reply_body' => "Hello {guest_name},\n\nThank you for your booking request at {hotel_name}. We have received your request and our team will confirm availability shortly.\n\nRoom: {room_name}\nStay: {checkin} to {checkout}\nRooms: {rooms_required}\nGuests: {guests}\n\nIf needed, you can reach us at {hotel_contact}.\n\nRegards,\n{hotel_name}",
            'email_template_event_auto_reply_subject' => 'Your event enquiry at {hotel_name}',
            'email_template_event_auto_reply_body' => "Hello {guest_name},\n\nThank you for your event enquiry at {hotel_name}. Our events team has received your request and will get back to you shortly.\n\nEvent: {event_type}\nDate: {event_date}\nGuests: {guests}\n\nIf needed, you can reach us at {hotel_contact}.\n\nRegards,\n{hotel_name}",
            'email_template_event_payment_link_subject' => 'Event payment link from {hotel_name}',
            'email_template_event_payment_link_body' => "Hello {guest_name},\n\nYour event payment link from {hotel_name} is ready.\n\nPayment Code: {payment_code}\nEvent: {event_type}\nEvent Date: {event_date}\nAmount: {amount}\n\nPay securely here:\n{payment_link}\n\nRegards,\n{hotel_name}",
        ];

        foreach ($settings as $key => $value) {
            $exists = $this->db->table('settings')->where('key', $key)->countAllResults();

            if ($exists) {
                continue;
            }

            $this->db->table('settings')->insert([
                'key' => $key,
                'value' => $value,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function down()
    {
        $this->db->table('settings')
            ->whereIn('key', [
                'receipt_pdf_style',
                'email_template_booking_auto_reply_subject',
                'email_template_booking_auto_reply_body',
                'email_template_event_auto_reply_subject',
                'email_template_event_auto_reply_body',
                'email_template_event_payment_link_subject',
                'email_template_event_payment_link_body',
            ])
            ->delete();
    }
}
