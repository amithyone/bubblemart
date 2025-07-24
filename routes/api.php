<?php
use App\Http\Controllers\Api\XtrapayProcessController;
use App\Http\Controllers\Api\PayVibeWebhookController;

// XtraPay webhook endpoint for payment notifications
Route::post('/webhook/xtrapay', [XtrapayProcessController::class, 'webhook'])->name('api.webhook.xtrapay');

// PayVibe webhook endpoint for payment notifications
Route::post('/webhook/payvibe', [PayVibeWebhookController::class, 'handleWebhook'])->name('api.webhook.payvibe');

// Manual payment verification endpoint (for testing/debugging)
Route::post('/verify/xtrapay', [XtrapayProcessController::class, 'verifyPayment'])->name('api.verify.xtrapay');

// Legacy routes for backward compatibility
Route::post('/ipn/xtrapay', [XtrapayProcessController::class, 'webhook'])->name('api.ipn.xtrapay');
Route::get('/ipn/xtrapay/check/{reference}', [XtrapayProcessController::class, 'verifyPayment'])->name('api.ipn.xtrapay.check');

Route::post('/test-api', [App\Http\Controllers\Api\TestApiController::class, 'testPost']); 