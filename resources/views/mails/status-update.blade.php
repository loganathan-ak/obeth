<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Status Updated</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 40px 0;
        }
        .email-container {
            background-color: #ffffff;
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .header {
            background-color: #1a73e8;
            padding: 20px;
            color: white;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px 0;
            color: #333;
        }
        .content p {
            margin: 10px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #777;
            text-align: center;
        }
        .status-badge {
            display: inline-block;
            background-color: #f59e0b;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>Obeth Graphics</h2>
        </div>

        <div class="content">
            <p>Hello,</p>

            <p>Order <strong>#{{ $order->order_id }}</strong> has been updated.</p>

            <p>
                <strong>Status:</strong>
                <span class="status-badge">{{ $order->status }}</span>
            </p>

            <p><strong>Project Title:</strong> {{ $order->project_title }}</p>

            @if(!empty($order->instructions))
                <p><strong>Instructions:</strong> {{ $order->instructions }}</p>
            @endif

            <p>To view or manage this order, please log into your dashboard.</p>

            <p class="text-gray-700">Thank you,<br>Team Obeth</p>
        </div>

    </div>
</body>
</html>
