<?php

namespace App\Http\Controllers;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Plans;
use App\Models\Transactions;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Mail\PaymentSuccessfullMail;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;


class PaymentController extends Controller
{

public function createPayment(Request $request)
{

     $user = auth()->user();

    // Check if user already has an active transaction
    $activeTransaction = Transactions::where('user_id', $user->id)
        ->where('status', 'Active')
        ->latest()
        ->first();
    
    if ($activeTransaction) {
        // Optional: parse PayPal JSON to get plan ID or name
        $paypalData = json_decode($activeTransaction->paypal_data, true);
        $paypalPlanId = $paypalData['plan_id'] ?? null;

              Alert::alert(
            'Active Plan Exists',
            'You already have an active subscription (Plan ID: ' . $paypalPlanId . '). Please cancel it before purchasing a new plan.',
            'warning'
        );

        return redirect()->back()->with('error', 'You already have an active plan. Please cancel your current subscription before purchasing a new one.');
    }

    $request->validate([
        'plan_id' => 'required|exists:plans,id',
    ]);

    $plan = Plans::findOrFail($request->plan_id);
    $paypalPlanId = $plan->plan_id;
    session(['plan_id' => $request->plan_id]);

    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));

    $accessToken = $provider->getAccessToken();
    $provider->setAccessToken($accessToken);

    $response = $provider->createSubscription([
        'plan_id' => $paypalPlanId,
        'application_context' => [
            'brand_name' => 'Obeth Designing',
            'locale' => 'en-US',
            'user_action' => 'SUBSCRIBE_NOW',
            'return_url' => route('paypal.success'),
            'cancel_url' => route('paypal.cancel'),
        ]
    ]);

    if (isset($response['links'])) {
        foreach ($response['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return redirect()->away($link['href']);
            }
        }
    }

    return redirect()->route('subscribers.dashboard')->with('error', 'Unable to initiate PayPal subscription.');
}

    

public function paymentSuccess(Request $request)
{
    $subscriptionId = $request->subscription_id;

    if (!$subscriptionId) {
        return redirect()->route('subscribers.dashboard')->with('error', 'Missing subscription ID.');
    }

    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();

    $subscription = $provider->showSubscriptionDetails($subscriptionId);

    if (!isset($subscription['status']) || $subscription['status'] !== 'ACTIVE') {
        return redirect()->route('subscribers.dashboard')->with('error', 'Subscription not active.');
    }

    $planId = session('plan_id');
    $plan = Plans::findOrFail($planId);

    $nextBillingTime = $subscription['billing_info']['next_billing_time'] ?? null;
    $expireDate = $nextBillingTime ? \Carbon\Carbon::parse($nextBillingTime) : now()->addDays($plan->validity_days ?? 30);
    $payment = Transactions::create([
        'user_id' => auth()->id(),
        'plan_id' => $plan->id,
        'credits_purchased' => $plan->credits,
        'amount_paid' => $plan->price,
        'payment_method' => 'paypal_subscription',
        'expire_date' => $expireDate,
        'transaction_id' => $subscriptionId,
        'subscription_id' => $subscriptionId,
        'status' => 'Active',
        'paypal_data' => json_encode($subscription),
    ]);

    auth()->user()->increment('credits', $plan->credits);

    // Assuming you pass user_id or use Auth::id()
    $user = Auth::user();

    $user->update([
        'is_active' => true,
    ]);

    Notifications::create([
        'created_by' => auth()->id(),
        'client_id' => auth()->id(),
        'message' => "Your payment has been successfully made.",
        'purpose' => 'payment',
        'order_id' => 0,
    ]);

    // Emails
    $user = auth()->user();
    $clientEmail = $user->email;
    $superadminEmail = User::where('role', 'superadmin')->value('email');

    $recipients = [$clientEmail, $superadminEmail];

    foreach ($recipients as $email) {
        Mail::to($email)->send(new PaymentSuccessfullMail($user, $plan, $payment));
    }

    return redirect()->route('subscribers.dashboard')->with('success', 'Subscription successful!');
}




    public function paymentCancel(){

    $user = auth()->user();

    // Check if user has no successful or active transaction
    $hasTransaction = Transactions::where('user_id', $user->id)
        ->where('status', 'Active')
        ->exists();

    // If no active transaction exists, delete user
    if (!$hasTransaction) {
        // Optionally: delete any related data (notifications, etc.)
        auth()->logout();
        $user->delete();
        
        return redirect()->route('register')->with('error', 'Your registration has been cancelled since payment was not completed.');
    }

    return redirect()->route('subscribers.dashboard')->with('error', 'Payment cancelled.');
  }



public function checkSubscription($subscriptionId)
{
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();

    $response = $provider->showSubscriptionDetails($subscriptionId);

    return response()->json($response);
}




public function cancelSubscription(Request $request)
{
    $subscriptionId = $request->input('subscription_id');

    if (!$subscriptionId) {
        return back()->with('error', 'Subscription ID is missing.');
    }

    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();

    // 1. Send cancel request to PayPal
    $provider->cancelSubscription($subscriptionId, 'User requested cancellation');

    // 2. Pull fresh subscription details
    $subscription = $provider->showSubscriptionDetails($subscriptionId);

    // 3. Update your transaction record
    $transaction = Transactions::where('transaction_id', $subscriptionId)
        ->latest()
        ->first();

    if ($transaction) {
        $transaction->update([
            'status' => $subscription['status'] === 'CANCELLED' ? 'Cancelled' : 'Pending',
            'paypal_data' => json_encode($subscription),
        ]);
    }

    // 4. Notify (optional)
    Notifications::create([
        'created_by' => Auth::id(),
        'client_id'  => Auth::id(),
        'message'    => "Subscription cancelled successfully.",
        'purpose'    => 'cancel-sub',
        'order_id'   => 0,
    ]);

    return back()->with('success', 'Subscription cancelled successfully.');
}



}
