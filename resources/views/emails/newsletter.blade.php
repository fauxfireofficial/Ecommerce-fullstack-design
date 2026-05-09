<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $mailSubject }}</title>
    <style>
        body {
            font-family: 'Inter', Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 0;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #f0f9ff;
            padding: 40px 20px;
            text-align: center;
            border-bottom: 1px solid #e0f2fe;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 800;
            color: #0369a1;
            letter-spacing: -1px;
            text-transform: uppercase;
        }
        .content {
            padding: 40px 35px;
            line-height: 1.8;
            font-size: 16px;
        }
        .content h2 {
            color: #0f172a;
            font-size: 22px;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 20px;
        }
        .message-body {
            color: #475569;
            margin-bottom: 35px;
        }
        .footer {
            background-color: #f8fafc;
            padding: 30px 20px;
            text-align: center;
            font-size: 13px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
        }
        .btn-container {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            padding: 16px 40px;
            background-color: #3b82f6;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 15px;
            box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.39);
        }
        .social-links {
            margin-bottom: 20px;
        }
        .social-links a {
            margin: 0 10px;
            color: #64748b;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name', 'Brand Store') }}</h1>
        </div>

        <div class="content">
            <h2>{{ $mailSubject }}</h2>
            <div class="message-body">
                {!! nl2br(e($mailContent)) !!}
            </div>
            
            <div class="btn-container">
                <a href="#" class="btn">Visit Our Store</a>
            </div>
        </div>
        
        <div class="footer">
            <div class="social-links">
                <a href="#">Website</a>
                <a href="#">Shop</a>
                <a href="#">Contact</a>
            </div>
            <p>&copy; {{ date('Y') }} Brand Store. All rights reserved.</p>
            <p>You're receiving this because you're a valued member of our community.</p>
            <p style="margin-top: 20px;">
                <a href="#" style="color: #3b82f6; text-decoration: none;">Unsubscribe</a>
            </p>
        </div>
    </div>
</body>
</html>
