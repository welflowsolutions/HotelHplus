<?php

namespace App\Libraries\Payments;

use App\Libraries\Payments\Contracts\PaymentGatewayInterface;
use App\Libraries\Payments\Gateways\CashfreeGateway;
use App\Libraries\Payments\Gateways\RazorpayGateway;

class PaymentGatewayFactory
{
    public function make(string $provider): ?PaymentGatewayInterface
    {
        return match (trim($provider)) {
            'cashfree' => new CashfreeGateway(
                trim((string) app_setting('cashfree_app_id', '')),
                trim((string) app_setting('cashfree_secret_key', '')),
                trim((string) app_setting('cashfree_environment', 'sandbox')),
                trim((string) app_setting('cashfree_webhook_secret', '')),
            ),
            'razorpay' => new RazorpayGateway(
                trim((string) app_setting('razorpay_key_id', '')),
                trim((string) app_setting('razorpay_key_secret', '')),
                trim((string) app_setting('razorpay_environment', 'sandbox')),
                trim((string) app_setting('razorpay_webhook_secret', '')),
            ),
            default => null,
        };
    }

    public function providerOptions(): array
    {
        return [
            'cashfree' => 'Cashfree',
            'razorpay' => 'Razorpay',
        ];
    }
}
