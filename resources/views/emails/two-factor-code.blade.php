<!DOCTYPE html>
<html>
<head>
    <title>Your Two-Factor Authentication Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .code {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            background: #f4f4f4;
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <h2>Your Two-Factor Authentication Code</h2>
    <p>Hello,</p>
    <p>Your two-factor authentication code is:</p>
    <div class="code">{{ $code }}</div>
    <p>This code will expire in 10 minutes.</p>
    <p>If you didn't request this code, please ignore this email or contact support if you have any concerns.</p>
    <div class="footer">
        <p>Best regards,<br>Your Application Team</p>
    </div>
</body>
</html>
