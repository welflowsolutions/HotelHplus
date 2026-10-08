<?php

namespace App\Libraries\Payments\DTO;

class CheckoutSession
{
    public function __construct(
        public readonly bool $success,
        public readonly string $message = '',
        public readonly ?string $gatewayOrderId = null,
        public readonly ?string $sessionToken = null,
        public readonly array $requestPayload = [],
        public readonly array $responsePayload = [],
    ) {
    }
}
