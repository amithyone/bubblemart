<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class XtrapayService
{
    public function initiateFunding(float $amount): array
    {
        $reference = $this->generateReference();
        $charge = 100 + ($amount * 1.5 / 100);
        if ($amount > 10000) {
            $charge = 100 + ($amount * 2.0 / 100);
        }
        $finalAmount = round($amount + $charge, 0);
        $key = env('XTRAPAY_ACCESS_KEY');
        
        // Check if XTRAPAY_ACCESS_KEY is set
        if (!$key || $key === 'your_default_access_key') {
            Log::warning('XtrapayService: XTRAPAY_ACCESS_KEY not set or invalid, using demo mode');
            // Fallback to demo mode for development
            return [
                'reference' => $reference,
                'accountNumber' => '1234567890',
                'bank' => 'Demo Bank',
                'accountName' => 'BUBLEMART DEMO ACCOUNT',
                'amount' => $finalAmount,
                'message' => "Please transfer ₦{$finalAmount} to the bank details above.",
                'expiry' => 600,
                'demo_mode' => true
            ];
        }
        
        try {
            $payload = [
                'reference' => $reference,
                'service' => 'bubble_mart'
            ];
            
            Log::info('XtrapayService: Making API request', [
                'url' => 'https://mobile.xtrapay.ng/api/virtual/generateAccount',
                'payload' => $payload,
                'key_length' => strlen($key)
            ]);
            
            $response = Http::withToken($key)
                ->timeout(30)
                ->post("https://mobile.xtrapay.ng/api/virtual/generateAccount", $payload);
                
            Log::info('XtrapayService: API response received', [
                'status_code' => $response->status(),
                'response_body' => $response->body()
            ]);
                
            if ($response->successful()) {
                $responseData = $response->json();
                Log::info('XtrapayService: Parsed response data', $responseData);
                
                if (isset($responseData['statusCode']) && $responseData['statusCode'] == 200 && isset($responseData['data'])) {
                    $accountData = $responseData['data'];
                    return [
                        'reference' => $accountData['reference'] ?? $reference,
                        'accountNumber' => $accountData['accountNumber'] ?? null,
                        'bank' => $accountData['bank'] ?? null,
                        'accountName' => $accountData['accountName'] ?? null,
                        'amount' => $accountData['amount'] ?? $finalAmount,
                        'message' => "Please transfer ₦{$finalAmount} to the bank details above.",
                        'expiry' => 600
                    ];
                } else {
                    Log::error('XtrapayService: API returned error', [
                        'response_data' => $responseData,
                        'status_code' => $responseData['statusCode'] ?? 'unknown'
                    ]);
                    
                    // Fall back to demo mode if API returns error
                    Log::warning('XtrapayService: Falling back to demo mode due to API error');
                    return [
                        'reference' => $reference,
                        'accountNumber' => '1234567890',
                        'bank' => 'Demo Bank',
                        'accountName' => 'BUBLEMART DEMO ACCOUNT',
                        'amount' => $finalAmount,
                        'message' => "Please transfer ₦{$finalAmount} to the bank details above. (Demo Mode - API Error: " . ($responseData['message'] ?? 'Unknown Error') . ")",
                        'expiry' => 600,
                        'demo_mode' => true
                    ];
                }
            } else {
                Log::error('XtrapayService: HTTP request failed', [
                    'status_code' => $response->status(),
                    'response_body' => $response->body()
                ]);
                
                // Fall back to demo mode if API fails
                Log::warning('XtrapayService: Falling back to demo mode due to API failure');
                return [
                    'reference' => $reference,
                    'accountNumber' => '1234567890',
                    'bank' => 'Demo Bank',
                    'accountName' => 'BUBLEMART DEMO ACCOUNT',
                    'amount' => $finalAmount,
                    'message' => "Please transfer ₦{$finalAmount} to the bank details above. (Demo Mode - API Unavailable)",
                    'expiry' => 600,
                    'demo_mode' => true
                ];
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('XtrapayService: Exception occurred', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Fall back to demo mode if exception occurs
            Log::warning('XtrapayService: Falling back to demo mode due to exception');
            return [
                'reference' => $reference,
                'accountNumber' => '1234567890',
                'bank' => 'Demo Bank',
                'accountName' => 'BUBLEMART DEMO ACCOUNT',
                'amount' => $finalAmount,
                'message' => "Please transfer ₦{$finalAmount} to the bank details above. (Demo Mode - Service Error)",
                'expiry' => 600,
                'demo_mode' => true
            ];
        }
    }

    /**
     * Check payment status with XtraPay API
     */
    public function checkPaymentStatus(string $reference): array
    {
        $key = env('XTRAPAY_ACCESS_KEY');
        
        // Check if XTRAPAY_ACCESS_KEY is set
        if (!$key || $key === 'your_default_access_key') {
            Log::warning('XtrapayService: XTRAPAY_ACCESS_KEY not set, using demo mode for payment status check');
            // For demo mode, simulate successful payment after a delay
            return [
                'status' => 'paid',
                'message' => 'Payment confirmed (Demo Mode)',
                'demo_mode' => true
            ];
        }
        
        try {
            $payload = [
                'reference' => $reference
            ];
            
            Log::info('XtrapayService: Checking payment status', [
                'reference' => $reference,
                'url' => 'https://mobile.xtrapay.ng/api/virtual/verifyPayment'
            ]);
            
            $response = Http::withToken($key)
                ->timeout(30)
                ->post("https://mobile.xtrapay.ng/api/virtual/verifyPayment", $payload);
                
            Log::info('XtrapayService: Payment status response received', [
                'status_code' => $response->status(),
                'response_body' => $response->body()
            ]);
                
            if ($response->successful()) {
                $responseData = $response->json();
                Log::info('XtrapayService: Parsed payment status data', $responseData);
                
                if (isset($responseData['statusCode']) && $responseData['statusCode'] == 200) {
                    $paymentData = $responseData['data'] ?? [];
                    $status = $paymentData['status'] ?? 'pending';
                    
                    // Map XtraPay status to our internal status
                    $mappedStatus = 'pending';
                    if ($status === 'success' || $status === 'completed' || $status === 'paid') {
                        $mappedStatus = 'paid';
                    } elseif ($status === 'failed' || $status === 'expired') {
                        $mappedStatus = 'failed';
                    }
                    
                    return [
                        'status' => $mappedStatus,
                        'message' => $paymentData['message'] ?? 'Payment status checked',
                        'data' => $paymentData
                    ];
                } else {
                    Log::error('XtrapayService: Payment status API returned error', [
                        'response_data' => $responseData
                    ]);
                    
                    return [
                        'status' => 'failed',
                        'message' => $responseData['message'] ?? 'Payment status check failed'
                    ];
                }
            } else {
                Log::error('XtrapayService: Payment status HTTP request failed', [
                    'status_code' => $response->status(),
                    'response_body' => $response->body()
                ]);
                
                return [
                    'status' => 'failed',
                    'message' => 'Payment status check failed - API unavailable'
                ];
            }
        } catch (\Exception $e) {
            Log::error('XtrapayService: Exception during payment status check', [
                'error' => $e->getMessage(),
                'reference' => $reference
            ]);
            
            return [
                'status' => 'failed',
                'message' => 'Payment status check failed - Service error'
            ];
        }
    }

    /**
     * Verify payment status with XtraPay API
     */
    public function verifyPayment(string $reference): array
    {
        $key = env('XTRAPAY_ACCESS_KEY');
        
        // Check if XTRAPAY_ACCESS_KEY is set
        if (!$key || $key === 'your_default_access_key') {
            Log::warning('XtrapayService: XTRAPAY_ACCESS_KEY not set, using demo mode for verification');
            // For demo mode, simulate successful payment after a delay
            return [
                'success' => true,
                'status' => 'success',
                'message' => 'Payment verified successfully (Demo Mode)',
                'demo_mode' => true
            ];
        }
        
        try {
            $payload = [
                'reference' => $reference
            ];
            
            Log::info('XtrapayService: Verifying payment', [
                'reference' => $reference,
                'url' => 'https://mobile.xtrapay.ng/api/virtual/verifyPayment'
            ]);
            
            $response = Http::withToken($key)
                ->timeout(30)
                ->post("https://mobile.xtrapay.ng/api/virtual/verifyPayment", $payload);
                
            Log::info('XtrapayService: Verification response received', [
                'status_code' => $response->status(),
                'response_body' => $response->body()
            ]);
                
            if ($response->successful()) {
                $responseData = $response->json();
                Log::info('XtrapayService: Parsed verification data', $responseData);
                
                if (isset($responseData['statusCode']) && $responseData['statusCode'] == 200) {
                    $paymentData = $responseData['data'] ?? [];
                    $status = $paymentData['status'] ?? 'pending';
                    
                    return [
                        'success' => $status === 'success' || $status === 'completed',
                        'status' => $status,
                        'message' => $paymentData['message'] ?? 'Payment verification completed',
                        'data' => $paymentData
                    ];
                } else {
                    Log::error('XtrapayService: Verification API returned error', [
                        'response_data' => $responseData
                    ]);
                    
                    return [
                        'success' => false,
                        'status' => 'error',
                        'message' => $responseData['message'] ?? 'Payment verification failed'
                    ];
                }
            } else {
                Log::error('XtrapayService: Verification HTTP request failed', [
                    'status_code' => $response->status(),
                    'response_body' => $response->body()
                ]);
                
                return [
                    'success' => false,
                    'status' => 'error',
                    'message' => 'Payment verification service unavailable'
                ];
            }
        } catch (\Exception $e) {
            Log::error('XtrapayService: Verification exception occurred', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'status' => 'error',
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verify webhook signature from XtraPay
     */
    public function verifyWebhookSignature($payload, $signature): bool
    {
        $secret = env('XTRAPAY_WEBHOOK_SECRET');
        
        if (!$secret || $secret === 'your_webhook_secret') {
            Log::warning('XtrapayService: XTRAPAY_WEBHOOK_SECRET not set, skipping signature verification');
            return true; // Allow in demo mode
        }
        
        $expectedSignature = hash_hmac('sha256', $payload, $secret);
        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Process webhook notification from XtraPay
     */
    public function processWebhook($payload): array
    {
        Log::info('XtrapayService: Processing webhook', $payload);
        
        try {
            $reference = $payload['reference'] ?? null;
            $status = $payload['status'] ?? null;
            $amount = $payload['amount'] ?? null;
            
            if (!$reference || !$status) {
                return [
                    'success' => false,
                    'message' => 'Invalid webhook payload: missing reference or status'
                ];
            }
            
            // Find the order by reference
            $order = \App\Models\Order::where('payment_reference', $reference)->first();
            
            if (!$order) {
                Log::warning('XtrapayService: Order not found for reference', ['reference' => $reference]);
                return [
                    'success' => false,
                    'message' => 'Order not found for reference: ' . $reference
                ];
            }
            
            // Update order status based on payment status
            if ($status === 'success' || $status === 'completed') {
                $order->update([
                    'status' => 'processing',
                    'payment_status' => 'paid',
                    'paid_at' => now()
                ]);
                
                Log::info('XtrapayService: Order payment confirmed', [
                    'order_id' => $order->id,
                    'reference' => $reference,
                    'status' => $status
                ]);
                
                return [
                    'success' => true,
                    'message' => 'Payment confirmed successfully',
                    'order_id' => $order->id
                ];
            } elseif ($status === 'failed' || $status === 'cancelled') {
                $order->update([
                    'status' => 'cancelled',
                    'payment_status' => 'failed'
                ]);
                
                Log::info('XtrapayService: Order payment failed', [
                    'order_id' => $order->id,
                    'reference' => $reference,
                    'status' => $status
                ]);
                
                return [
                    'success' => false,
                    'message' => 'Payment failed',
                    'order_id' => $order->id
                ];
            } else {
                Log::info('XtrapayService: Payment status pending', [
                    'order_id' => $order->id,
                    'reference' => $reference,
                    'status' => $status
                ]);
                
                return [
                    'success' => false,
                    'message' => 'Payment status: ' . $status,
                    'order_id' => $order->id
                ];
            }
            
        } catch (\Exception $e) {
            Log::error('XtrapayService: Webhook processing error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Webhook processing failed: ' . $e->getMessage()
            ];
        }
    }
    
    private function generateReference(): string
    {
        return substr(str_shuffle(time() . mt_rand(100000, 999999)), 0, 12);
    }
} 