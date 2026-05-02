<!DOCTYPE html>
<html>
<head>
    <title>We'd love your feedback!</title>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f4f5; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; }
        .header { margin-bottom: 20px; }
        .header h1 { margin: 0; color: #18181b; font-size: 24px; }
        .content { color: #3f3f46; line-height: 1.6; }
        .stars { margin: 20px 0; font-size: 30px; color: #fbbf24; letter-spacing: 5px; }
        .btn { display: inline-block; background: #10b981; color: white; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Your Order was Delivered!</h1>
        </div>
        <div class="content">
            <p>Hello {{ $order->user->name }},</p>
            <p>We hope you are enjoying the items from your recent order <strong>#{{ $order->order_number }}</strong>.</p>
            
            <div class="stars">★★★★★</div>
            
            <p>We'd love to hear your thoughts. Your feedback helps us improve and helps other customers make better decisions.</p>
            
            <a href="{{ route('orders.show', $order->id) }}" class="btn">Leave a Review</a>
        </div>
    </div>
</body>
</html>
