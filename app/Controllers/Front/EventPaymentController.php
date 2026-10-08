<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class EventPaymentController extends BaseController
{
    private function render(string $view, array $data = []): string
    {
        $data['footerRooms'] = $data['footerRooms'] ?? $this->footerRooms();
        $data['currencySymbol'] = $data['currencySymbol'] ?? app_setting('system_currency_symbol', '₹');
        $data['content'] = view($view, $data);

        return view('front/layouts/app', $data);
    }

    public function checkout(string $paymentCode): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $eventPayment = service('paymentService')->eventPaymentByCode($paymentCode);

        if ($eventPayment === null) {
            return redirect()->to(base_url('events'))->with('error', 'Event payment link not found.');
        }

        if ((string) ($eventPayment['payment_status'] ?? '') === 'paid') {
            return redirect()->to(base_url('event-payment/status/' . $paymentCode));
        }

        if ((string) ($eventPayment['payment_status'] ?? '') === 'cancelled') {
            return redirect()->to(base_url('event-payment/status/' . $paymentCode));
        }

        if (! service('paymentService')->gatewayModeActive() || ! service('paymentService')->isReady()) {
            return redirect()->to(base_url('events'))->with('error', 'Online event payment is not available right now.');
        }

        $checkout = service('paymentService')->prepareEventCheckout($eventPayment);

        return $this->render('front/event_payment_checkout', [
            'title' => 'Complete Event Payment',
            'activePage' => 'events',
            'headerTheme' => 'light',
            'metaRobots' => 'noindex, nofollow',
            'canonicalUrl' => base_url('events'),
            'eventPayment' => $eventPayment,
            'gatewayLabel' => service('paymentService')->currentGatewayLabel(),
            'gatewayEnvironment' => service('paymentService')->currentGateway()?->environment() ?? 'production',
            'gatewayProvider' => service('paymentService')->currentProvider(),
            'checkoutReady' => $checkout->success,
            'checkoutSessionId' => $checkout->sessionToken,
            'checkoutPayload' => $checkout->responsePayload,
            'checkoutScriptUrl' => service('paymentService')->checkoutScriptUrl(),
        ]);
    }

    public function paymentReturn()
    {
        $paymentCode = trim((string) $this->request->getGet('payment'));
        $gatewayOrderId = trim((string) $this->request->getGet('order_id'));

        if ($paymentCode === '') {
            return redirect()->to(base_url('events'))->with('error', 'Invalid event payment return request.');
        }

        $eventPayment = service('paymentService')->eventPaymentByCode($paymentCode);

        if ($eventPayment === null) {
            return redirect()->to(base_url('events'))->with('error', 'Event payment not found.');
        }

        service('paymentService')->verifyEventPayment($eventPayment, $gatewayOrderId !== '' ? $gatewayOrderId : null);

        return redirect()->to(base_url('event-payment/status/' . $paymentCode . '?source=return'));
    }

    public function status(string $paymentCode): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $eventPayment = service('paymentService')->eventPaymentByCode($paymentCode);

        if ($eventPayment === null) {
            return redirect()->to(base_url('events'))->with('error', 'Event payment not found.');
        }

        $transaction = service('paymentService')->latestEventTransaction((int) $eventPayment['id']);

        return $this->render('front/event_payment_status', [
            'title' => 'Event Payment Status',
            'activePage' => 'events',
            'headerTheme' => 'light',
            'metaRobots' => 'noindex, nofollow',
            'canonicalUrl' => base_url('events'),
            'eventPayment' => $eventPayment,
            'transaction' => $transaction,
            'receiptData' => service('paymentService')->eventReceiptData($eventPayment, $transaction),
        ]);
    }

    public function receipt(string $paymentCode): ResponseInterface|\CodeIgniter\HTTP\RedirectResponse
    {
        $eventPayment = service('paymentService')->eventPaymentByCode($paymentCode);

        if ($eventPayment === null) {
            return redirect()->to(base_url('events'))->with('error', 'Event receipt not found.');
        }

        if ((string) ($eventPayment['payment_status'] ?? '') !== 'paid') {
            return redirect()->to(base_url('event-payment/status/' . $paymentCode))->with('error', 'Receipt becomes available after successful payment.');
        }

        $transaction = service('paymentService')->latestEventTransaction((int) $eventPayment['id']);
        $receipt = service('paymentService')->eventReceiptData($eventPayment, $transaction);
        $pdf = service('receiptPdfBuilder')->build($receipt);

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('X-Robots-Tag', 'noindex, nofollow')
            ->setHeader('Content-Disposition', 'attachment; filename="event-receipt-' . preg_replace('/[^A-Za-z0-9\-]/', '', $paymentCode) . '.pdf"')
            ->setBody($pdf);
    }

    public function razorpayVerify(): ResponseInterface
    {
        $payload = $this->request->getJSON(true);

        if (! is_array($payload)) {
            $payload = $this->request->getPost();
        }

        $paymentCode = trim((string) ($payload['payment_code'] ?? ''));
        $orderId = trim((string) ($payload['razorpay_order_id'] ?? $payload['gateway_order_id'] ?? ''));
        $paymentId = trim((string) ($payload['razorpay_payment_id'] ?? ''));
        $signature = trim((string) ($payload['razorpay_signature'] ?? ''));

        if ($paymentCode === '' || $orderId === '' || $paymentId === '' || $signature === '') {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'failed', 'message' => 'Incomplete Razorpay payment response.']);
        }

        $gateway = service('paymentGatewayFactory')->make('razorpay');

        if (! $gateway || ! method_exists($gateway, 'verifyCheckoutSignature') || ! $gateway->verifyCheckoutSignature($orderId, $paymentId, $signature)) {
            return $this->response->setStatusCode(401)->setJSON(['status' => 'failed', 'message' => 'Invalid Razorpay payment signature.']);
        }

        $eventPayment = service('paymentService')->eventPaymentByCode($paymentCode);

        if ($eventPayment === null) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'failed', 'message' => 'Event payment not found.']);
        }

        service('paymentService')->markTransactionPaymentId($orderId, $paymentId);
        $result = service('paymentService')->verifyEventPayment($eventPayment, $orderId);

        return $this->response->setJSON([
            'status' => $result->status,
            'message' => $result->message,
            'redirect_url' => base_url('event-payment/status/' . $paymentCode . '?source=razorpay'),
        ]);
    }

    private function footerRooms(): array
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists('rooms')) {
            return [];
        }

        return $db->table('rooms')->where('is_active', 1)->orderBy('sort_order', 'ASC')->limit(3)->get()->getResultArray();
    }
}
