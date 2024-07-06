<!DOCTYPE html>
<html>
<head>
    <title>Payment Confirmation</title>
</head>
<body>
    <h1>{{ $detail['subject'] }}</h1>
    <p>Dear {{ $detail['name'] }},</p>
    <p>Thank you for your purchase of . The amount of ${{ $detail['price'] / 100 }} has been successfully charged to your card.</p>
    <p>customer email ID <strong>{!! $detail['email_id'] !!}</strong></p>
    <p>do verify this code <strong>{!! $detail['random_text'] !!}</strong></p>
    <p>Regards,<br>Sreaming</p>
</body>
</html>
