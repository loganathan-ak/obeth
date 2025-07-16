<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Created</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
<div style="max-width: 500px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 6px;">
<h2 style="color: #007bff;">🎉 New Order Created</h2>

<p><strong>Job ID:</strong> {{ $order->order_id }}</p>
<p><strong>Client Name:</strong> {{ \App\Models\User::where('id', $order->created_by)->first()->first_name ?? 'N/A' }}</p>
<p><strong>Order Details:</strong></p>
<ul>
    <li><strong>OBETH ID:</strong> {{ $order->obeth_id }}</li>
    <li><strong>Order ID:</strong> {{ $order->order_id ?? '—' }}</li>
    <li><strong>Project title:</strong> {{ $order->project_title }}</li>
    <li><strong>Request type:</strong> {{ $order->request_type }}</li>
    <li><strong>Sub‑service:</strong> {{ $order->sub_service ?? '—' }}</li>
    <li><strong>Instructions:</strong> {{ $order->instructions ?? '—' }}</li>
    <li><strong>Colours:</strong> {{ $order->colors ?? '—' }}</li>
    <li><strong>Size:</strong> {{ $order->size ?? '—' }}</li>
    <li><strong>Other size:</strong> {{ $order->other_size ?? '—' }}</li>
    <li><strong>Software:</strong> {{ $order->software ?? '—' }}</li>
</ul>
<p>You can view more details by logging into your dashboard.</p>
<p class="text-gray-700">Thank you,<br>Team Obeth</p>
</div>
</body>
</html>