<!DOCTYPE html>
<html>
<head>
    <style>
        .email-container {
            font-family: 'Inter', sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #e1e1e1;
            border-radius: 12px;
            background-color: #ffffff;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #f8f9fa;
        }
        .header h2 {
            color: #d9534f;
            margin: 0;
        }
        .content {
            padding: 20px 0;
            line-height: 1.6;
            color: #333;
        }
        .otp-box {
            background-color: #f8f9fa;
            border: 2px dashed #d9534f;
            font-size: 36px;
            font-weight: bold;
            color: #d9534f;
            letter-spacing: 8px;
            padding: 20px;
            text-align: center;
            margin: 25px 0;
            border-radius: 8px;
        }
        .footer {
            font-size: 12px;
            color: #777;
            margin-top: 30px;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .warning {
            font-size: 13px;
            color: #856404;
            background-color: #fff3cd;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ffeeba;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>Password Reset Request</h2>
        </div>
        
        <div class="content">
            <p>Hello,</p>
            <p>We received a request to reset the password for your account. Please use the verification code below to proceed with the reset process.</p>
            
            <div class="otp-box">{{ $otp }}</div>
            
            <div class="warning">
                <strong>Security Note:</strong> This code will expire in 10 minutes. If you did not request a password reset, please secure your account immediately or ignore this email.
            </div>
        </div>
        
        <div class="footer">
            &copy; 2026 Brand Ecommerce. Secure Account Management.
        </div>
    </div>
</body>
</html>
