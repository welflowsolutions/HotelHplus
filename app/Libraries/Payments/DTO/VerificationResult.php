<?php

namespace App\Libraries\Payments\DTO;

class VerificationResult
{
    public function __construct(
        public readonly bool $success,
        public readonly string $status,
        public readonly string $message = '',
        public readonly ?string $gatewayOrderId = null,
        public readonly ?string $gatewayPaymentId = null,
        public readonly array $payload = [],
    ) {
    }
}
