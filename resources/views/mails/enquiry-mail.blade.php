<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Enquiry Submitted</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .card { background: #fff; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        h2 { color: #1a73e8; }
        p { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="card">
        <h2>New Enquiry Received</h2>

        <p><strong>Name:</strong> {{ $data['name'] }}</p>
        <p><strong>Email:</strong> {{ $data['email'] }}</p>
        <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
        <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
        <p><strong>Message:</strong></p>
        <p>{{ $data['message'] }}</p>

        <p class="text-gray-700">Thank you,<br>Team Obeth</p>
    </div>
</body>
</html>
