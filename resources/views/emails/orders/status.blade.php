<!DOCTYPE html>
<html>
<head>
    <title>Order Status Update</title>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f4f5; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 1px solid #e4e4e7; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #18181b; font-size: 24px; }
        .content { color: #3f3f46; line-height: 1.6; }
        .order-box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .status-badge { display: inline-block; padding: 6px 12px; border-radius: 20px; font-weight: bold; font-size: 14px; }
        .status-confirmed { background: #dbeafe; color: #1e40af; }
        .status-cancelled { background: #fee2e2; color: #b91c1c; }
        .status-processing { background: #fef3c7; color: #92400e; }
        .btn { display: inline-block; background: #2563eb; color: white; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Status Update</h1>
        </div>
        <div class="content">
            <p>Hello {{ $order->user->name }},</p>
            <p>Your order <strong>#{{ $order->order_number }}</strong> has been updated to: 
                <span class="status-badge status-{{ strtolower($status) }}">{{ ucfirst($status) }}</span>
            </p>
            
            <div class="order-box">
                <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
            </div>
            
            <p>If you have any questions, please contact our support team.</p>
            
            <center>
                <a href="{{ route('orders.show', $order->id) }}" class="btn">View Order Details</a>
            </center>
        </div>
    </div>
</body>
</html>
