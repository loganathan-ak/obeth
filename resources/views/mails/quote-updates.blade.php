<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quote Update Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
    <table width="100%" style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <tr>
            <td style="text-align: center;">
                <h2 style="color: #333;">Quote Update</h2>
            </td>
        </tr>
        <tr>
            <td>
                <p>Dear {{ $user->first_name }} {{ $user->last_name }},</p>
                <p>We wanted to let you know that there has been an update to your Order.</p>
                <p>
                    <strong>Order Title:</strong> {{ ucfirst($order->project_title) }} <br>
                    <strong>Status:</strong> {{ ucfirst($quote->status) }} <br>
                    <strong>Credits:</strong> {{ $quote->credits_used }} <br>
                    <strong>Updated At:</strong> {{ $quote->updated_at->format('d M Y, h:i A') }}
                </p>
                @if($quote->status === 'accepted')
                    <p style="color: green;">
                        🎉 Good news! Your quote has been <strong>accepted</strong>.
                    </p>
                @elseif($quote->status === 'rejected')
                    <p style="color: red;">
                        Unfortunately, your quote was <strong>rejected</strong>.
                    </p>
                @else
                    <p>
                        Please review the updated quote details in your dashboard.
                    </p>
                @endif
                <p class="text-gray-700">Thank you,<br>Team Obeth</p>
            </td>
        </tr>
    </table>
</body>
</html>
