<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\XtrapayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class XtrapayProcessController extends Controller
{
    protected $xtrapayService;

    public function __construct()
    {
        $this->xtrapayService = new XtrapayService();
    }

    /**
     * Handle XtraPay webhook notifications
     */
    public function webhook(Request $request)
    {
        Log::info('XtrapayProcessController: Webhook received', [
            'headers' => $request->headers->all(),
            'payload' => $request->all()
        ]);

        try {
            // Get the webhook signature from headers
            $signature = $request->header('X-Xtrapay-Signature');
            $payload = $request->getContent();

            // Verify webhook signature
            if (!$this->xtrapayService->verifyWebhookSignature($payload, $signature)) {
                Log::warning('XtrapayProcessController: Invalid webhook signature', [
                    'signature' => $signature,
                    'payload' => $payload
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid signature'
                ], 400);
            }

            // Process the webhook
            $result = $this->xtrapayService->processWebhook($request->all());

            Log::info('XtrapayProcessController: Webhook processed', $result);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => 'Webhook processed successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('XtrapayProcessController: Webhook processing error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Webhook processing failed'
            ], 500);
        }
    }

    /**
     * Manual payment verification endpoint (for testing/debugging)
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'reference' => 'required|string'
        ]);

        try {
            $result = $this->xtrapayService->verifyPayment($request->reference);

            Log::info('XtrapayProcessController: Manual verification', [
                'reference' => $request->reference,
                'result' => $result
            ]);

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('XtrapayProcessController: Manual verification error', [
                'reference' => $request->reference,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Verification failed: ' . $e->getMessage()
            ], 500);
        }
    }
} 