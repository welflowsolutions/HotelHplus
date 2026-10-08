<?php

namespace Config;

use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    public static function appSettings(bool $getShared = true): \App\Libraries\AppSettings
    {
        if ($getShared) {
            return static::getSharedInstance('appSettings');
        }

        return new \App\Libraries\AppSettings();
    }

    public static function appMailer(bool $getShared = true): \App\Libraries\AppMailer
    {
        if ($getShared) {
            return static::getSharedInstance('appMailer');
        }

        return new \App\Libraries\AppMailer();
    }

    public static function auditLogger(bool $getShared = true): \App\Libraries\AuditLogger
    {
        if ($getShared) {
            return static::getSharedInstance('auditLogger');
        }

        return new \App\Libraries\AuditLogger();
    }

    public static function adminPermissions(bool $getShared = true): \App\Libraries\AdminPermissions
    {
        if ($getShared) {
            return static::getSharedInstance('adminPermissions');
        }

        return new \App\Libraries\AdminPermissions();
    }

    public static function paymentGatewayFactory(bool $getShared = true): \App\Libraries\Payments\PaymentGatewayFactory
    {
        if ($getShared) {
            return static::getSharedInstance('paymentGatewayFactory');
        }

        return new \App\Libraries\Payments\PaymentGatewayFactory();
    }

    public static function paymentService(bool $getShared = true): \App\Libraries\Payments\PaymentService
    {
        if ($getShared) {
            return static::getSharedInstance('paymentService');
        }

        return new \App\Libraries\Payments\PaymentService(static::paymentGatewayFactory(false));
    }

    public static function receiptPdfBuilder(bool $getShared = true): \App\Libraries\Receipts\ReceiptPdfBuilder
    {
        if ($getShared) {
            return static::getSharedInstance('receiptPdfBuilder');
        }

        return new \App\Libraries\Receipts\ReceiptPdfBuilder();
    }

    public static function rateLimiter(bool $getShared = true): \App\Libraries\RateLimiter
    {
        if ($getShared) {
            return static::getSharedInstance('rateLimiter');
        }

        return new \App\Libraries\RateLimiter();
    }
}
