<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Image Revision Submitted</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div style="background-color: #ffffff; padding: 30px; border-radius: 8px; max-width: 600px; margin: auto;">
        <h2 style="color: #333333;">📤 Image Revision Submitted</h2>

        <p>Hello {{ $recipientName }},</p>

        <p>
            A new image revision has been submitted for the project titled: 
            <strong>{{ $order->project_title }}</strong>.
        </p>

        <p><strong>Submitted by:</strong> {{ $submittedBy }}</p>
        <p><strong>Order ID:</strong> {{ $order->order_id }}</p>

        <p>You can review the revised image and feedback using the button below:</p>


        <p>If you have any questions or need further clarification, please don't hesitate to contact the team.</p>

        <p class="text-gray-700">Thank you,<br>Team Obeth</p>
    </div>
</body>
</html>
