<?php

use Config\Services;

if (! function_exists('payment_service')) {
    function payment_service(): \App\Libraries\Payments\PaymentService
    {
        return Services::paymentService();
    }
}

if (! function_exists('payment_gateway_options')) {
    function payment_gateway_options(): array
    {
        return payment_service()->providerOptions();
    }
}
