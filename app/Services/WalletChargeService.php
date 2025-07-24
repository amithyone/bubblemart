<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class WalletChargeService
{
    /**
     * Calculate charges for wallet funding based on amount
     * 
     * @param float $amount The amount to be funded
     * @return array Returns array with base_amount, charge, total_amount, and charge_breakdown
     */
    public static function calculateCharges($amount)
    {
        $baseAmount = $amount;
        $charge = 0;
        $chargeBreakdown = [];

        // Tier 1: ₦1,000 - ₦9,999: ₦100 + 1.5%
        if ($baseAmount >= 1000 && $baseAmount <= 9999) {
            $fixedCharge = 100;
            $percentageCharge = $baseAmount * 0.015; // 1.5%
            $charge = $fixedCharge + $percentageCharge;
            
            $chargeBreakdown = [
                'tier' => 'Tier 1 (₦1,000 - ₦9,999)',
                'fixed_charge' => $fixedCharge,
                'percentage_rate' => '1.5%',
                'percentage_amount' => $percentageCharge,
                'total_charge' => $charge
            ];
        }
        // Tier 2: ₦10,000 - ₦39,999: ₦200 + 1.5%
        elseif ($baseAmount >= 10000 && $baseAmount <= 39999) {
            $fixedCharge = 200;
            $percentageCharge = $baseAmount * 0.015; // 1.5%
            $charge = $fixedCharge + $percentageCharge;
            
            $chargeBreakdown = [
                'tier' => 'Tier 2 (₦10,000 - ₦39,999)',
                'fixed_charge' => $fixedCharge,
                'percentage_rate' => '1.5%',
                'percentage_amount' => $percentageCharge,
                'total_charge' => $charge
            ];
        }
        // Tier 3: ₦40,000 and above: ₦400 + 1.5%
        elseif ($baseAmount >= 40000) {
            $fixedCharge = 400;
            $percentageCharge = $baseAmount * 0.015; // 1.5%
            $charge = $fixedCharge + $percentageCharge;
            
            $chargeBreakdown = [
                'tier' => 'Tier 3 (₦40,000+)',
                'fixed_charge' => $fixedCharge,
                'percentage_rate' => '1.5%',
                'percentage_amount' => $percentageCharge,
                'total_charge' => $charge
            ];
        }
        // Below minimum: No charges (but should not happen in normal flow)
        else {
            $chargeBreakdown = [
                'tier' => 'Below minimum',
                'fixed_charge' => 0,
                'percentage_rate' => '0%',
                'percentage_amount' => 0,
                'total_charge' => 0
            ];
        }

        $totalAmount = $baseAmount + $charge;

        return [
            'base_amount' => $baseAmount,
            'charge' => $charge,
            'total_amount' => $totalAmount,
            'charge_breakdown' => $chargeBreakdown,
            'formatted' => [
                'base_amount' => '₦' . number_format($baseAmount, 2),
                'charge' => '₦' . number_format($charge, 2),
                'total_amount' => '₦' . number_format($totalAmount, 2)
            ]
        ];
    }

    /**
     * Get charge information for display
     * 
     * @param float $amount
     * @return array
     */
    public static function getChargeInfo($amount)
    {
        $charges = self::calculateCharges($amount);
        
        return [
            'amount' => $amount,
            'charge' => $charges['charge'],
            'total' => $charges['total_amount'],
            'breakdown' => $charges['charge_breakdown'],
            'formatted' => $charges['formatted']
        ];
    }

    /**
     * Validate if amount is within acceptable range
     * 
     * @param float $amount
     * @return bool
     */
    public static function isValidAmount($amount)
    {
        return $amount >= 1000 && $amount <= 1000000;
    }

    /**
     * Get amount limits for wallet funding
     * 
     * @return array
     */
    public static function getAmountLimits()
    {
        return [
            'min' => 1000,
            'max' => 1000000,
            'currency' => 'NGN'
        ];
    }

    /**
     * Process payment for wallet funding
     * 
     * @param string $reference Payment reference
     * @param float $amount Payment amount
     * @param string $gateway Payment gateway (xtrapay, payvibe, etc.)
     * @return array
     */
    public function processPayment(string $reference, float $amount, string $gateway = 'xtrapay'): array
    {
        try {
            // Find the pending transaction with this reference
            $transaction = \App\Models\WalletTransaction::where('reference', $reference)
                ->where('type', 'credit')
                ->where('status', 'pending')
                ->first();

            if (!$transaction) {
                Log::warning('WalletChargeService: Transaction not found', [
                    'reference' => $reference,
                    'gateway' => $gateway
                ]);

                return [
                    'success' => false,
                    'message' => 'Transaction not found'
                ];
            }

            // Check if transaction is already processed
            if ($transaction->status === 'completed') {
                Log::info('WalletChargeService: Transaction already processed', [
                    'reference' => $reference,
                    'transaction_id' => $transaction->id
                ]);

                return [
                    'success' => true,
                    'message' => 'Transaction already processed',
                    'user_id' => $transaction->wallet->user_id
                ];
            }

            // Verify amount matches
            if ($transaction->amount != $amount) {
                Log::warning('WalletChargeService: Amount mismatch', [
                    'reference' => $reference,
                    'expected_amount' => $transaction->amount,
                    'received_amount' => $amount
                ]);

                return [
                    'success' => false,
                    'message' => 'Amount mismatch'
                ];
            }

            // Process the transaction
            DB::beginTransaction();

            try {
                // Update transaction status
                $transaction->update([
                    'status' => 'completed',
                    'processed_at' => now(),
                    'gateway' => $gateway
                ]);

                // Credit the wallet
                $wallet = $transaction->wallet;
                $wallet->increment('balance', $amount);

                DB::commit();

                Log::info('WalletChargeService: Payment processed successfully', [
                    'reference' => $reference,
                    'amount' => $amount,
                    'gateway' => $gateway,
                    'user_id' => $wallet->user_id,
                    'new_balance' => $wallet->fresh()->balance
                ]);

                return [
                    'success' => true,
                    'message' => 'Payment processed successfully',
                    'user_id' => $wallet->user_id,
                    'amount' => $amount,
                    'new_balance' => $wallet->fresh()->balance
                ];

            } catch (\Exception $e) {
                DB::rollBack();
                
                Log::error('WalletChargeService: Database transaction failed', [
                    'reference' => $reference,
                    'error' => $e->getMessage()
                ]);

                return [
                    'success' => false,
                    'message' => 'Database transaction failed'
                ];
            }

        } catch (\Exception $e) {
            Log::error('WalletChargeService: Payment processing error', [
                'reference' => $reference,
                'amount' => $amount,
                'gateway' => $gateway,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Payment processing failed'
            ];
        }
    }
} 