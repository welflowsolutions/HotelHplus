<?php

namespace App\Libraries\Payments\Contracts;

use App\Libraries\Payments\DTO\CheckoutSession;
use App\Libraries\Payments\DTO\RefundResult;
use App\Libraries\Payments\DTO\VerificationResult;

interface PaymentGatewayInterface
{
    public function id(): string;

    public function label(): string;

    public function environment(): string;

    public function isConfigured(): bool;

    public function checkoutScriptUrl(): string;

    public function createCheckout(array $booking, array $room): CheckoutSession;

    public function verifyOrder(string $gatewayOrderId): VerificationResult;

    public function refundPayment(string $gatewayOrderId, ?string $gatewayPaymentId, float $amount, string $currency, string $refundReference, string $note = ''): RefundResult;

    public function fetchRefund(string $gatewayOrderId, string $gatewayRefundId, ?string $gatewayPaymentId = null): RefundResult;

    public function verifyWebhookSignature(array $headers, string $rawBody): bool;

    public function extractWebhookOrderId(array $payload): ?string;
}
