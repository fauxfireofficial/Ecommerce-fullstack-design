<!DOCTYPE html>
<html>
<head>
    <style>
        .email-container {
            font-family: 'Inter', sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #e1e1e1;
            border-radius: 10px;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #0d6efd;
            letter-spacing: 5px;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            font-size: 12px;
            color: #777;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>{{ $purpose == 'registration' ? 'Welcome to Brand!' : 'Reset Your Password' }}</h2>
        <p>Hello,</p>
        <p>Please use the following One-Time Password (OTP) to {{ $purpose == 'registration' ? 'verify your account' : 'reset your password' }}. This code is valid for 10 minutes.</p>
        
        <div class="otp-code">{{ $otp }}</div>
        
        <p>If you did not request this code, please ignore this email.</p>
        
        <div class="footer">
            &copy; 2026 Brand Ecommerce. All rights reserved.
        </div>
    </div>
</body>
</html>
