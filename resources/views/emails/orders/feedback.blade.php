<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>We'd love your feedback!</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f4f8; padding: 30px 20px; }
        .wrapper { max-width: 620px; margin: 0 auto; }
        .card { background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }

        /* Header */
        .header { background: linear-gradient(135deg, #059669 0%, #10b981 100%); padding: 40px 40px 30px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 26px; font-weight: 700; margin-bottom: 6px; }
        .header p { color: rgba(255,255,255,0.85); font-size: 14px; }

        /* Body */
        .body { padding: 35px 40px; text-align: center; }
        .greeting { font-size: 16px; color: #1e293b; margin-bottom: 12px; font-weight: 600; }
        .message { font-size: 14px; color: #475569; line-height: 1.7; margin-bottom: 25px; }

        .stars { margin: 25px 0; font-size: 32px; color: #fbbf24; letter-spacing: 8px; }

        /* CTA Button */
        .btn { display: inline-block; background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 13px 32px; border-radius: 8px; font-weight: 700; font-size: 15px; letter-spacing: 0.3px; margin-top: 10px; }

        /* Footer */
        .footer { background: #f8fafc; padding: 20px 40px; text-align: center; border-top: 1px solid #e2e8f0; }
        .footer p { font-size: 12px; color: #94a3b8; line-height: 1.6; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        <div class="header">
            <h1>Your Order was Delivered!</h1>
            <p>Order #{{ $order->order_number }}</p>
        </div>

        <div class="body">
            <p class="greeting">Hello {{ $order->user->name ?? 'Customer' }},</p>
            <p class="message">
                We hope you are enjoying your recent purchase from Faux Fire Official. 
                Your feedback is incredibly valuable to us and helps other shoppers make the best choices.
            </p>
            
            <div class="stars">★★★★★</div>
            
            <p class="message">
                Could you take a moment to tell us what you think? It only takes a few seconds!
            </p>
            
            <a href="{{ route('orders.show', $order->id) }}" class="btn">Leave a Review</a>
        </div>

        <div class="footer">
            <p><strong>Faux Fire Official</strong><br>
            Thank you for being a part of our community.<br>
            &copy; {{ date('Y') }} Faux Fire Official. All rights reserved.</p>
        </div>
    </div>
</div>
</body>
</html>
