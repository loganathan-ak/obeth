<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayPalWebhookController extends Controller
{
public function handle(Request $request)
{
    $data = $request->all();
    $eventType = $data['event_type'] ?? 'UNKNOWN';

    Log::info("🔔 PayPal Webhook received: {$eventType}", $data);

    $resource = $data['resource'] ?? [];

    $paypalSubscriptionId = null;
    $paypalPaymentId = null;

    if ($eventType === 'PAYMENT.SALE.COMPLETED') {
        $paypalSubscriptionId = $resource['billing_agreement_id'] ?? null;
        $paypalPaymentId = $resource['id'] ?? null;
    } else if (str_starts_with($eventType, 'BILLING.SUBSCRIPTION.')) {
        $paypalSubscriptionId = $resource['id'] ?? null;
        // For subscription events, there isn't typically an 'individual payment ID'
        // associated directly in the resource for these events.
        // If you *must* have something for paypalPaymentId here, you might use
        // the subscription ID itself, but it's often not necessary.
        // For now, we'll keep it null unless specifically for PAYMENT.SALE.COMPLETED
    }

    Log::info("  --- Determined PayPal IDs for Event: {$eventType} ---");
    Log::info("  PayPal Subscription ID (for DB lookup): {$paypalSubscriptionId}");
    Log::info("  PayPal Individual Payment ID (for new transaction): {$paypalPaymentId}");
    Log::info("  ---------------------------------");

    if (!$paypalSubscriptionId) {
        Log::warning("⚠️ No PayPal subscription ID found for event: {$eventType}");
        return response()->json(['status' => 'missing_subscription_id'], 422);
    }

    // --- Handle BILLING.SUBSCRIPTION.CANCELLED ---
    if ($eventType === 'BILLING.SUBSCRIPTION.CANCELLED') {
        Transactions::where('paypal_subscription_id', $paypalSubscriptionId) // <--- Use new column here
            ->latest()
            ->first()?->update(['status' => 'Cancelled']);
        Log::info("🚫 Subscription cancelled: {$paypalSubscriptionId}");
    }

    // --- Handle PAYMENT.SALE.COMPLETED (Recurring Payments) ---
    if ($eventType === 'PAYMENT.SALE.COMPLETED') {
        // Lookup by paypal_subscription_id now
        $latestSubscriptionTransaction = Transactions::where('paypal_subscription_id', $paypalSubscriptionId) // <--- Use new column here
                                                     ->latest()
                                                     ->first();

        if ($latestSubscriptionTransaction) {
            $plan = Plans::find($latestSubscriptionTransaction->plan_id);

            if (!$plan) {
                Log::error("❌ Plan not found for transaction ID: {$latestSubscriptionTransaction->id}, PayPal Subscription ID: {$paypalSubscriptionId}");
                return response()->json(['status' => 'plan_not_found'], 404);
            }

            // Mark the previous transaction as "Expired"
            // IMPORTANT: You might want to update the *specific* previous recurring payment
            // rather than the subscription's initial payment. If you're creating a new row
            // for each payment, the concept of "expiring the previous transaction"
            // might need to be refined. If this `latestSubscriptionTransaction` is always
            // meant to be the *initial* one, then marking it expired on *every* renewal
            // might not be ideal.
            // A better approach for recurring payments might be to *always* create new
            // 'Active' transactions and let previous ones remain as 'Completed'
            // or 'Active' (if you don't track individual expiry for each payment)
            // However, if your current model means 'transaction_id' is for the subscription itself,
            // and you want to mark the 'parent' as expired, then this might be okay for now.
            // Revisit your transaction status flow for recurring payments carefully.
            // For now, let's assume `latestSubscriptionTransaction` is the *previous renewal's transaction*.
            $latestSubscriptionTransaction->update(['status' => 'Expired']);
            Log::info("Previous transaction {$latestSubscriptionTransaction->id} marked as Expired for subscription: {$paypalSubscriptionId}.");


            $expire = isset($resource['next_billing_time'])
                ? Carbon::parse($resource['next_billing_time'])
                : now()->addDays((int)($plan->validity_days ?? 30));

            // Create new transaction for the *new payment*
            Transactions::create([
                'user_id' => $latestSubscriptionTransaction->user_id,
                'plan_id' => $latestSubscriptionTransaction->plan_id,
                'credits_purchased' => (int)($plan->credits ?? 0),
                'amount_paid' => (float)($resource['amount']['total'] ?? $plan->price), // Prefer webhook amount if available
                'payment_method' => 'paypal_subscription',
                'expire_date' => $expire,
                'transaction_id' => $paypalPaymentId, // This remains the individual payment ID
                'subscription_id' => $paypalSubscriptionId, // <--- Store the subscription ID here
                'status' => 'Active',
                'paypal_data' => json_encode($resource),
            ]);
            Log::info("💰 New recurring payment recorded for subscription: {$paypalSubscriptionId} with payment ID: {$paypalPaymentId}.");

            // Add credits again
            $user = User::find($latestSubscriptionTransaction->user_id);
            if ($user) {
                $user->increment('credits', (int)($plan->credits ?? 0));
                Log::info("Credits incremented for user: {$user->id} by {$plan->credits}.");
            } else {
                Log::warning("⚠️ User not found for transaction with ID: {$latestSubscriptionTransaction->id}.");
            }

        } else {
            Log::warning("⚠️ No matching *subscription-related transaction* found in your DB for PayPal Subscription ID: {$paypalSubscriptionId}. This means the initial subscription or a prior payment might not have been recorded correctly with this ID.");
            // Potentially handle creating an initial record here if none exists for this subscription ID.
        }
    }

    return response()->json(['status' => 'received']);
}

}

