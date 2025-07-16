<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New User Registration</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <tr>
            <td style="background-color: #4F46E5; color: #ffffff; padding: 20px; text-align: center;">
                <h2 style="margin: 0;">📝 New User Registered</h2>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px;">
                <p>Hello,</p>
                <p>A new user has successfully registered on the platform. Below are the details:</p>

                <table cellpadding="5" cellspacing="0" width="100%" style="border-collapse: collapse;">
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td>{{ $newUser->first_name }} {{ $newUser->last_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $newUser->email }}</td>
                    </tr>
                    @if($newUser->mobile_number)
                    <tr>
                        <td><strong>Mobile Number:</strong></td>
                        <td>{{ $newUser->mobile_number }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Country:</strong></td>
                        <td>{{ $newUser->country }}</td>
                    </tr>
                    <tr>
                        <td><strong>Obeth ID:</strong></td>
                        <td>{{ $newUser->obeth_id }}</td>
                    </tr>
                </table>

                <p style="margin-top: 20px;">You can log in to the admin panel to view or manage this user.</p>
                <p style="margin-top: 30px;">Regards,<br><strong>Your Application</strong></p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f0f0f0; text-align: center; padding: 10px; font-size: 12px; color: #888;">
                This is an automated message. Please do not reply.
            </td>
        </tr>
    </table>
    <p class="text-gray-700">Thank you,<br>Team Obeth</p>
</body>
</html>
