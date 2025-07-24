<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PayVibeService;
use App\Services\WalletChargeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayVibeWebhookController extends Controller
{
    protected PayVibeService $payVibeService;
    protected WalletChargeService $walletChargeService;

    public function __construct(PayVibeService $payVibeService, WalletChargeService $walletChargeService)
    {
        $this->payVibeService = $payVibeService;
        $this->walletChargeService = $walletChargeService;
    }

    public function handleWebhook(Request $request)
    {
        Log::info('PayVibeWebhook: Received webhook', $request->all());

        try {
            // Process the webhook payload
            $webhookData = $this->payVibeService->processWebhook($request->all());

            if (isset($webhookData['error'])) {
                Log::error('PayVibeWebhook: Webhook processing error', $webhookData);
                return response()->json(['error' => $webhookData['message']], 400);
            }

            $reference = $webhookData['reference'];
            $status = $webhookData['status'];
            $amount = $webhookData['amount'];

            // Only process completed payments
            if ($status === 'completed' || $status === 'success') {
                // Process the wallet charge
                $result = $this->walletChargeService->processPayment($reference, $amount, 'payvibe');

                if ($result['success']) {
                    Log::info('PayVibeWebhook: Payment processed successfully', [
                        'reference' => $reference,
                        'amount' => $amount,
                        'user_id' => $result['user_id'] ?? null
                    ]);

                    return response()->json(['status' => 'success']);
                } else {
                    Log::error('PayVibeWebhook: Payment processing failed', [
                        'reference' => $reference,
                        'error' => $result['message']
                    ]);

                    return response()->json(['error' => 'Payment processing failed'], 500);
                }
            } else {
                Log::info('PayVibeWebhook: Payment not completed', [
                    'reference' => $reference,
                    'status' => $status
                ]);

                return response()->json(['status' => 'ignored']);
            }
        } catch (\Exception $e) {
            Log::error('PayVibeWebhook: Exception occurred', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }
} 