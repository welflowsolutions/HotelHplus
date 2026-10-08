<?php

namespace App\Libraries\Receipts;

class ReceiptPdfBuilder
{
    private const PAGE_WIDTH = 300.0;
    private const PAGE_HEIGHT = 640.0;

    private string $stream = '';

    public function build(array $receipt): string
    {
        $receipt = $this->normalize($receipt);
        $this->stream = '';

        $this->renderBackground($receipt);
        $this->renderHeader($receipt);
        $this->renderBody($receipt);
        $this->renderFooter($receipt);

        $streamLength = strlen($this->stream);

        $objects = [];
        $objects[] = "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj";
        $objects[] = "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj";
        $objects[] = "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 " . self::PAGE_WIDTH . ' ' . self::PAGE_HEIGHT . "] /Resources << /Font << /F1 4 0 R /F2 5 0 R >> >> /Contents 6 0 R >> endobj";
        $objects[] = "4 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj";
        $objects[] = "5 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >> endobj";
        $objects[] = "6 0 obj << /Length {$streamLength} >> stream\n{$this->stream}\nendstream endobj";

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object . "\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }

        $pdf .= "trailer << /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
        $pdf .= "startxref\n{$xrefOffset}\n%%EOF";

        return $pdf;
    }

    private function normalize(array $receipt): array
    {
        $currency = (string) ($receipt['currency'] ?? 'INR');
        $amount = (string) ($receipt['amount'] ?? '0.00');

        $receipt['hotel_name'] = (string) ($receipt['hotel_name'] ?? 'Hotel H Plus');
        $receipt['hotel_address'] = (string) ($receipt['hotel_address'] ?? 'Opposite Sector-7, Pipli Road, Kurukshetra');
        $receipt['hotel_phone'] = (string) ($receipt['hotel_phone'] ?? '+91 92530 72122');
        $receipt['hotel_email'] = (string) ($receipt['hotel_email'] ?? 'info@hotelhplus.in');
        $receipt['tax_label'] = (string) ($receipt['tax_label'] ?? '');
        $receipt['tax_number'] = (string) ($receipt['tax_number'] ?? '');
        $receipt['gst_enabled'] = (string) ($receipt['gst_enabled'] ?? '0');
        $receipt['gst_rate'] = (string) ($receipt['gst_rate'] ?? '0.00');
        $receipt['taxable_amount'] = (string) ($receipt['taxable_amount'] ?? $amount);
        $receipt['gst_amount'] = (string) ($receipt['gst_amount'] ?? '0.00');
        $receipt['receipt_number'] = (string) ($receipt['receipt_number'] ?? '—');
        $receipt['booking_code'] = (string) ($receipt['booking_code'] ?? '—');
        $receipt['payment_reference'] = (string) ($receipt['payment_reference'] ?? '—');
        $receipt['payment_status'] = (string) ($receipt['payment_status'] ?? 'Payment Successful');
        $receipt['payment_date'] = (string) ($receipt['payment_date'] ?? date('d M Y, h:i A'));
        $receipt['guest_name'] = (string) ($receipt['guest_name'] ?? 'Guest');
        $receipt['guest_phone'] = (string) ($receipt['guest_phone'] ?? '—');
        $receipt['guest_email'] = (string) ($receipt['guest_email'] ?? '—');
        $receipt['room_name'] = (string) ($receipt['room_name'] ?? 'Room Booking');
        $receipt['checkin'] = (string) ($receipt['checkin'] ?? '—');
        $receipt['checkout'] = (string) ($receipt['checkout'] ?? '—');
        $receipt['rooms_required'] = (string) ($receipt['rooms_required'] ?? '1');
        $receipt['guests'] = (string) ($receipt['guests'] ?? '1');
        $receipt['nights'] = (string) ($receipt['nights'] ?? '1');
        $receipt['currency'] = $currency;
        $receipt['amount'] = $amount;
        $receipt['receipt_style'] = $this->normalizeStyle((string) ($receipt['receipt_style'] ?? 'classic'));
        $receipt['issued_on'] = (string) ($receipt['issued_on'] ?? date('d M Y, h:i A'));
        $receipt['amount_display'] = trim($currency . ' ' . $amount);
        $receipt['status_message'] = $this->statusMessage((string) $receipt['payment_status']);

        return $receipt;
    }

    private function renderBackground(array $receipt): void
    {
        $palette = $this->palette($receipt);

        $this->drawRectTop(0, 0, self::PAGE_WIDTH, self::PAGE_HEIGHT, $palette['page']);
        $this->drawRectTop(18, 18, 264, 604, $palette['card'], $palette['border']);
    }

    private function renderHeader(array $receipt): void
    {
        $palette = $this->palette($receipt);
        $gold = $palette['accent'];
        $textMuted = $palette['muted'];
        $textStrong = $palette['strong'];
        $status = (string) $receipt['payment_status'];
        $statusLabel = stripos($status, 'success') !== false || stripos($status, 'paid') !== false
            ? 'PAID'
            : strtoupper($status);

        $this->drawTextBlock(150, 38, (string) $receipt['hotel_name'], 15, 'bold', $textStrong, 0, 1.1, 'center');
        $this->drawTextBlock(150, 58, (string) $receipt['gst_enabled'] === '1' ? 'TAX INVOICE / PAYMENT RECEIPT' : 'PAYMENT RECEIPT', 7.8, 'bold', $gold, 0, 1.1, 'center');
        $this->drawTextBlock(150, 77, (string) $receipt['hotel_address'], 6.6, 'regular', $textMuted, 212, 1.22, 'center');
        $this->drawTextBlock(150, 96, 'Phone: ' . (string) $receipt['hotel_phone'], 6.4, 'regular', $textMuted, 214, 1.15, 'center');
        $this->drawTextBlock(150, 110, 'Email: ' . (string) $receipt['hotel_email'], 6.4, 'regular', $textMuted, 214, 1.15, 'center');
        if ((string) $receipt['tax_label'] !== '' && (string) $receipt['tax_number'] !== '') {
            $this->drawTextBlock(150, 123, (string) $receipt['tax_label'] . ': ' . (string) $receipt['tax_number'], 6.2, 'regular', $textMuted, 214, 1.15, 'center');
        }

        $this->drawDashLineTop(36, 132, 264, $palette['border']);
        $this->drawReceiptInfoRow(150, 'Receipt No.', (string) $receipt['receipt_number'], 'bold');
        $this->drawReceiptInfoRow(172, 'Paid On', (string) $receipt['payment_date']);
        $this->drawReceiptInfoRow(194, 'Status', $statusLabel, 'bold', $gold);
        $this->drawDashLineTop(36, 216, 264, $palette['border']);
    }

    private function renderBody(array $receipt): void
    {
        $palette = $this->palette($receipt);
        $textStrong = $palette['strong'];
        $amountFill = $palette['amount_fill'];

        $this->drawRectTop(36, 236, 228, 62, $amountFill);
        $this->drawTextBlock(150, 252, 'AMOUNT PAID', 6.8, 'bold', $palette['amount_label'], 0, 1.1, 'center');
        $this->drawTextBlock(150, 270, (string) $receipt['amount_display'], 18.5, 'bold', $palette['amount_value'], 0, 1.08, 'center');

        $this->drawSectionHeading(36, 322, 'Stay Details');
        $this->drawReceiptInfoRow(344, 'Guest', (string) $receipt['guest_name'], 'bold');
        $this->drawReceiptInfoRow(366, 'Phone', (string) $receipt['guest_phone']);
        $this->drawReceiptInfoRow(388, 'Room', (string) $receipt['room_name'], 'bold');
        $this->drawReceiptInfoRow(410, 'Check-in', (string) $receipt['checkin']);
        $this->drawReceiptInfoRow(432, 'Check-out', (string) $receipt['checkout']);
        $this->drawReceiptInfoRow(454, 'Rooms / Guests', (string) $receipt['rooms_required'] . ' / ' . (string) $receipt['guests']);
        $this->drawReceiptInfoRow(476, 'Nights', (string) $receipt['nights']);

        $paymentRefY = 516;

        if ((string) $receipt['gst_enabled'] === '1') {
            $this->drawDashLineTop(36, 492, 264, $palette['border']);
            $this->drawReceiptInfoRow(506, 'Taxable Value', (string) $receipt['currency'] . ' ' . (string) $receipt['taxable_amount']);
            $this->drawReceiptInfoRow(528, 'GST @ ' . rtrim(rtrim((string) $receipt['gst_rate'], '0'), '.') . '%', (string) $receipt['currency'] . ' ' . (string) $receipt['gst_amount']);
            $paymentRefY = 552;
        }

        $this->drawDashLineTop(36, $paymentRefY - 18, 264, $palette['border']);
        $this->drawTextBlock(36, $paymentRefY, strtoupper('Payment Ref.'), 6.6, 'bold', [123, 129, 141], 80, 1.1);
        $this->drawTextBlock(264, $paymentRefY - 1, (string) $receipt['payment_reference'], 7.5, 'regular', $textStrong, 150, 1.2, 'right');

    }

    private function renderFooter(array $receipt): void
    {
        $palette = $this->palette($receipt);

        $this->drawTextBlock(150, 570, 'Thank you for choosing ' . (string) $receipt['hotel_name'] . '.', 6.8, 'bold', $palette['strong'], 216, 1.1, 'center');
    }

    private function drawSectionHeading(float $x, float $yTop, string $label): void
    {
        $this->drawTextBlock($x, $yTop, strtoupper($label), 7.5, 'bold', [196, 157, 58], 0, 1.1);
    }

    private function normalizeStyle(string $style): string
    {
        return in_array($style, ['classic', 'signature', 'minimal'], true) ? $style : 'classic';
    }

    private function palette(array $receipt): array
    {
        return match ((string) ($receipt['receipt_style'] ?? 'classic')) {
            'signature' => [
                'page' => [244, 241, 234],
                'card' => [255, 255, 255],
                'border' => [206, 184, 136],
                'accent' => [176, 124, 32],
                'strong' => [20, 24, 32],
                'muted' => [91, 98, 112],
                'amount_fill' => [45, 34, 22],
                'amount_label' => [230, 219, 196],
                'amount_value' => [224, 176, 68],
            ],
            'minimal' => [
                'page' => [250, 250, 250],
                'card' => [255, 255, 255],
                'border' => [220, 225, 232],
                'accent' => [31, 41, 55],
                'strong' => [15, 23, 42],
                'muted' => [100, 116, 139],
                'amount_fill' => [241, 245, 249],
                'amount_label' => [100, 116, 139],
                'amount_value' => [15, 23, 42],
            ],
            default => [
                'page' => [248, 246, 241],
                'card' => [255, 255, 255],
                'border' => [229, 219, 199],
                'accent' => [196, 157, 58],
                'strong' => [20, 24, 32],
                'muted' => [92, 97, 108],
                'amount_fill' => [17, 19, 24],
                'amount_label' => [188, 194, 205],
                'amount_value' => [196, 157, 58],
            ],
        };
    }

    private function drawMetaRow(float $x, float $yTop, string $label, string $value): void
    {
        $this->drawTextBlock($x, $yTop, strtoupper($label), 6.9, 'bold', [175, 181, 194], 152, 1.08);
        $this->drawTextBlock($x, $yTop + 8, $value, 8.3, 'bold', [255, 255, 255], 152, 1.1);
    }

    private function drawReceiptInfoRow(
        float $yTop,
        string $label,
        string $value,
        string $valueFont = 'regular',
        array $valueColor = [20, 24, 32]
    ): void {
        $this->drawTextBlock(36, $yTop, strtoupper($label), 6.6, 'bold', [123, 129, 141], 92, 1.1);
        $this->drawTextBlock(264, $yTop - 1, $value, 8.1, $valueFont, $valueColor, 150, 1.16, 'right');
    }

    private function drawDashLineTop(float $x1, float $yTop, float $x2, array $stroke): void
    {
        $dashWidth = 5.0;
        $gap = 4.0;
        $x = $x1;

        while ($x < $x2) {
            $end = min($x + $dashWidth, $x2);
            $this->drawLineTop($x, $yTop, $end, $yTop, $stroke, 0.8);
            $x += $dashWidth + $gap;
        }
    }

    private function drawReceiptPair(
        float $x,
        float $yTop,
        string $leftLabel,
        string $leftValue,
        string $rightLabel,
        string $rightValue
    ): void {
        $this->drawLabelValueStack($x, $yTop, $leftLabel, $leftValue, 142, 8.9, 'bold');
        $this->drawLabelValueStack($x + 174, $yTop, $rightLabel, $rightValue, 142, 8.9, 'bold');
    }

    private function drawLabelValueStack(
        float $x,
        float $yTop,
        string $label,
        string $value,
        float $maxWidth,
        float $valueSize = 12.5,
        string $valueFont = 'bold'
    ): void
    {
        $this->drawTextBlock($x, $yTop, strtoupper($label), 7, 'bold', [123, 129, 141], $maxWidth, 1.1);
        $this->drawTextBlock($x, $yTop + 10, $value, $valueSize, $valueFont, [20, 24, 32], $maxWidth, 1.2);
    }

    private function drawLabelValueInline(
        float $x,
        float $yTop,
        string $label,
        string $value,
        float $labelWidth,
        float $valueWidth = 0,
        float $valueSize = 10.5,
        string $valueFont = 'regular',
        array $valueColor = [20, 24, 32]
    ): void {
        $this->drawTextBlock($x, $yTop, strtoupper($label), 6.9, 'bold', [123, 129, 141], $labelWidth, 1.1);
        $this->drawTextBlock($x + $labelWidth, $yTop, $value, $valueSize, $valueFont, $valueColor, $valueWidth, 1.16);
    }

    private function drawTextBlock(
        float $x,
        float $yTop,
        string $text,
        float $fontSize,
        string $font = 'regular',
        array $color = [0, 0, 0],
        float $maxWidth = 0,
        float $lineHeightMultiplier = 1.4,
        string $align = 'left'
    ): float {
        $lines = $maxWidth > 0 ? $this->wrapText($text, $fontSize, $maxWidth) : [$text];
        $lineHeight = $fontSize * $lineHeightMultiplier;

        foreach ($lines as $index => $line) {
            $lineWidth = $this->estimateTextWidth($line, $fontSize);
            $drawX = $x;

            if ($align === 'right') {
                $drawX = $x - $lineWidth;
            } elseif ($align === 'center') {
                $drawX = $x - ($lineWidth / 2);
            }

            $this->drawText($drawX, $yTop + ($index * $lineHeight), $line, $fontSize, $font, $color);
        }

        return count($lines) * $lineHeight;
    }

    private function drawText(float $x, float $yTop, string $text, float $fontSize, string $font, array $color): void
    {
        $y = self::PAGE_HEIGHT - $yTop - $fontSize;
        $fontName = $font === 'bold' ? 'F2' : 'F1';

        $this->stream .= "BT\n";
        $this->stream .= '/' . $fontName . ' ' . $this->formatNumber($fontSize) . " Tf\n";
        $this->stream .= $this->rgbFill($color);
        $this->stream .= '1 0 0 1 ' . $this->formatNumber($x) . ' ' . $this->formatNumber($y) . " Tm\n";
        $this->stream .= '(' . $this->escapeText($text) . ") Tj\n";
        $this->stream .= "ET\n";
    }

    private function drawRectTop(float $x, float $yTop, float $width, float $height, ?array $fill = null, ?array $stroke = null, float $lineWidth = 1): void
    {
        $y = self::PAGE_HEIGHT - $yTop - $height;

        if ($fill !== null) {
            $this->stream .= $this->rgbFill($fill);
        }

        if ($stroke !== null) {
            $this->stream .= $this->rgbStroke($stroke);
            $this->stream .= $this->formatNumber($lineWidth) . " w\n";
        }

        $operator = $fill !== null && $stroke !== null ? 'B' : ($fill !== null ? 'f' : 'S');
        $this->stream .= $this->formatNumber($x) . ' ' . $this->formatNumber($y) . ' ' . $this->formatNumber($width) . ' ' . $this->formatNumber($height) . " re {$operator}\n";
    }

    private function drawLineTop(float $x1, float $y1Top, float $x2, float $y2Top, array $stroke, float $lineWidth = 1): void
    {
        $y1 = self::PAGE_HEIGHT - $y1Top;
        $y2 = self::PAGE_HEIGHT - $y2Top;

        $this->stream .= $this->rgbStroke($stroke);
        $this->stream .= $this->formatNumber($lineWidth) . " w\n";
        $this->stream .= $this->formatNumber($x1) . ' ' . $this->formatNumber($y1) . " m\n";
        $this->stream .= $this->formatNumber($x2) . ' ' . $this->formatNumber($y2) . " l\n";
        $this->stream .= "S\n";
    }

    private function wrapText(string $text, float $fontSize, float $maxWidth): array
    {
        $text = trim(preg_replace('/\s+/', ' ', $text) ?? '');

        if ($text === '') {
            return [''];
        }

        $words = explode(' ', $text);
        $lines = [];
        $current = '';

        foreach ($words as $word) {
            $candidate = $current === '' ? $word : $current . ' ' . $word;

            if ($this->estimateTextWidth($candidate, $fontSize) <= $maxWidth) {
                $current = $candidate;
                continue;
            }

            if ($current !== '') {
                $lines[] = $current;
                $current = $this->estimateTextWidth($word, $fontSize) > $maxWidth ? '' : $word;

                if ($current === '') {
                    foreach ($this->splitLongWord($word, $fontSize, $maxWidth) as $chunk) {
                        $lines[] = $chunk;
                    }
                }
                continue;
            }

            foreach ($this->splitLongWord($word, $fontSize, $maxWidth) as $chunk) {
                $lines[] = $chunk;
            }
        }

        if ($current !== '') {
            $lines[] = $current;
        }

        return $lines;
    }

    private function splitLongWord(string $word, float $fontSize, float $maxWidth): array
    {
        if ($this->estimateTextWidth($word, $fontSize) <= $maxWidth) {
            return [$word];
        }

        $characters = preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $chunks = [];
        $current = '';

        foreach ($characters as $character) {
            $candidate = $current . $character;

            if ($current !== '' && $this->estimateTextWidth($candidate, $fontSize) > $maxWidth) {
                $chunks[] = $current;
                $current = $character;
                continue;
            }

            $current = $candidate;
        }

        if ($current !== '') {
            $chunks[] = $current;
        }

        return $chunks;
    }

    private function estimateTextWidth(string $text, float $fontSize): float
    {
        $width = 0.0;
        $characters = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        foreach ($characters as $character) {
            if (preg_match('/[ilI1\|\.\,\:\;]/', $character) === 1) {
                $width += 0.22;
            } elseif (preg_match('/[mwMW@#%&QGO]/', $character) === 1) {
                $width += 0.88;
            } elseif ($character === ' ') {
                $width += 0.28;
            } else {
                $width += 0.56;
            }
        }

        return $width * $fontSize;
    }

    private function statusMessage(string $status): string
    {
        return match (strtolower(trim($status))) {
            'payment successful', 'paid' => 'Thank you for your booking. This receipt confirms that we have successfully received your payment for the stay listed above. We look forward to welcoming you to Hotel H Plus.',
            'payment pending', 'pending' => 'Your payment is still being verified. Please keep this receipt for reference while our system confirms the final payment status.',
            'payment failed', 'failed' => 'Your payment could not be completed successfully. Please contact our team if you need help with a retry or booking assistance.',
            default => 'This receipt has been generated for your booking reference and payment record.',
        };
    }

    private function rgbFill(array $color): string
    {
        return $this->formatColor($color) . " rg\n";
    }

    private function rgbStroke(array $color): string
    {
        return $this->formatColor($color) . " RG\n";
    }

    private function formatColor(array $color): string
    {
        return $this->formatNumber(($color[0] ?? 0) / 255)
            . ' ' . $this->formatNumber(($color[1] ?? 0) / 255)
            . ' ' . $this->formatNumber(($color[2] ?? 0) / 255);
    }

    private function formatNumber(float $number): string
    {
        $formatted = number_format($number, 3, '.', '');

        return rtrim(rtrim($formatted, '0'), '.');
    }

    private function escapeText(string $value): string
    {
        return str_replace(
            ['\\', '(', ')', "\r", "\n"],
            ['\\\\', '\(', '\)', '', ' '],
            $value
        );
    }
}
