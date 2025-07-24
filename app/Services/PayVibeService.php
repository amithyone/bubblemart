<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayVibeService
{
    private string $baseUrl = 'https://payvibeapi.six3tech.com/api';
    private string $productIdentifier = 'fadded_sms';

    public function initiateFunding(float $amount): array
    {
        $reference = $this->generateReference();
        
        try {
            $payload = [
                'reference' => $reference,
                'product_identifier' => $this->productIdentifier,
                'amount' => round($amount * 100) // Convert to kobo (smallest currency unit)
            ];
            
            Log::info('PayVibeService: Making API request', [
                'url' => $this->baseUrl . '/v1/payments/virtual-accounts/initiate',
                'payload' => $payload
            ]);
            
            $response = Http::timeout(30)
                ->post($this->baseUrl . '/v1/payments/virtual-accounts/initiate', $payload);
                
            Log::info('PayVibeService: API response received', [
                'status_code' => $response->status(),
                'response_body' => $response->body()
            ]);
                
            if ($response->successful()) {
                $responseData = $response->json();
                Log::info('PayVibeService: Parsed response data', $responseData);
                
                if (isset($responseData['status']) && $responseData['status'] === 'success' && isset($responseData['data'])) {
                    $accountData = $responseData['data'];
                    return [
                        'reference' => $accountData['reference'] ?? $reference,
                        'accountNumber' => $accountData['account_number'] ?? null,
                        'bank' => $accountData['bank_name'] ?? null,
                        'accountName' => $accountData['account_name'] ?? null,
                        'amount' => $accountData['amount'] ?? $amount,
                        'message' => "Please transfer ₦{$amount} to the bank details above.",
                        'expiry' => 600
                    ];
                } else {
                    Log::error('PayVibeService: API returned error', [
                        'response_data' => $responseData,
                        'status' => $responseData['status'] ?? 'unknown'
                    ]);
                    
                    return [
                        'error' => true,
                        'message' => 'Payment service temporarily unavailable. Please try again later.',
                        'reference' => $reference,
                        'api_error' => $responseData['message'] ?? 'Unknown Error'
                    ];
                }
            } else {
                Log::error('PayVibeService: HTTP request failed', [
                    'status_code' => $response->status(),
                    'response_body' => $response->body()
                ]);
                
                return [
                    'error' => true,
                    'message' => 'Payment service temporarily unavailable. Please try again later.',
                    'reference' => $reference,
                    'http_error' => $response->status()
                ];
            }
        } catch (\Exception $e) {
            Log::error('PayVibeService: Exception occurred', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'error' => true,
                'message' => 'Payment service temporarily unavailable. Please try again later.',
                'reference' => $reference,
                'exception' => $e->getMessage()
            ];
        }
    }

    public function checkPaymentStatus(string $reference): array
    {
        try {
            $payload = [
                'reference' => $reference,
                'product_identifier' => $this->productIdentifier
            ];
            
            Log::info('PayVibeService: Checking payment status', [
                'url' => $this->baseUrl . '/v1/payments/virtual-accounts/status',
                'payload' => $payload
            ]);
            
            $response = Http::timeout(30)
                ->post($this->baseUrl . '/v1/payments/virtual-accounts/status', $payload);
                
            Log::info('PayVibeService: Status check response', [
                'status_code' => $response->status(),
                'response_body' => $response->body()
            ]);
                
            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['status']) && $responseData['status'] === 'success' && isset($responseData['data'])) {
                    $paymentData = $responseData['data'];
                    $status = $paymentData['status'] ?? 'pending';
                    
                    return [
                        'status' => $status,
                        'amount' => $paymentData['amount'] ?? 0,
                        'reference' => $paymentData['reference'] ?? $reference,
                        'paid_at' => $paymentData['paid_at'] ?? null,
                        'message' => $this->getStatusMessage($status)
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'Unable to check payment status',
                        'reference' => $reference
                    ];
                }
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Payment status check failed',
                    'reference' => $reference
                ];
            }
        } catch (\Exception $e) {
            Log::error('PayVibeService: Status check exception', [
                'message' => $e->getMessage(),
                'reference' => $reference
            ]);
            
            return [
                'status' => 'error',
                'message' => 'Payment status check failed',
                'reference' => $reference
            ];
        }
    }

    public function verifyPayment(string $reference): array
    {
        return $this->checkPaymentStatus($reference);
    }

    public function processWebhook($payload): array
    {
        try {
            Log::info('PayVibeService: Processing webhook', $payload);
            
            if (!isset($payload['reference']) || !isset($payload['status'])) {
                return [
                    'error' => true,
                    'message' => 'Invalid webhook payload'
                ];
            }
            
            $reference = $payload['reference'];
            $status = $payload['status'];
            $amount = $payload['amount'] ?? 0;
            
            return [
                'reference' => $reference,
                'status' => $status,
                'amount' => $amount,
                'paid_at' => $payload['paid_at'] ?? now(),
                'message' => $this->getStatusMessage($status)
            ];
        } catch (\Exception $e) {
            Log::error('PayVibeService: Webhook processing error', [
                'message' => $e->getMessage(),
                'payload' => $payload
            ]);
            
            return [
                'error' => true,
                'message' => 'Webhook processing failed'
            ];
        }
    }

    private function getStatusMessage(string $status): string
    {
        return match($status) {
            'completed', 'success' => 'Payment completed successfully',
            'pending' => 'Payment is pending',
            'failed' => 'Payment failed',
            'expired' => 'Payment expired',
            default => 'Payment status unknown'
        };
    }

    private function generateReference(): string
    {
        return 'PAYVIBE_' . time() . '_' . rand(1000, 9999);
    }
} 