<?php

namespace App\Libraries\Payments\DTO;

class RefundResult
{
    public function __construct(
        public readonly bool $success,
        public readonly string $status,
        public readonly string $message = '',
        public readonly ?string $gatewayRefundId = null,
        public readonly ?string $gatewayPaymentId = null,
        public readonly array $payload = [],
    ) {
    }
}
