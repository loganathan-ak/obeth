<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
    <div style="max-width: 500px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 6px;">
        <h2 style="color: #28a745;">✅ Payment Successful</h2>

        <p>{{ $user->first_name ?? 'User' }},</p>

        <p>We have received your payment successfully. Below are the details of transaction:</p>

        <ul>
            <li><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</li>
            <li><strong>Plan:</strong> {{ $plan->name }}</li>
            <li><strong>Credits Purchased:</strong> {{ $payment->credits_purchased }}</li>
            <li><strong>Amount Paid:</strong> ₹{{ number_format($payment->amount_paid, 2) }}</li>
            <li><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method) }}</li>
            <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y, h:i A') }}</li>
        </ul>

        <p class="text-gray-700">Thank you,<br>Team Obeth</p>
    </div>
</body>
</html>
