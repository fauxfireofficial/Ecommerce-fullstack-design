<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Status Update</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f4f8; padding: 30px 20px; }
        .wrapper { max-width: 620px; margin: 0 auto; }
        .card { background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }

        /* Header */
        .header { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); padding: 40px 40px 30px; text-align: center; }
        .header h1 { color: #ffffff; font-size: 26px; font-weight: 700; margin-bottom: 6px; }
        .header p { color: rgba(255,255,255,0.85); font-size: 14px; }

        /* Body */
        .body { padding: 35px 40px; }
        .greeting { font-size: 16px; color: #1e293b; margin-bottom: 12px; font-weight: 600; }
        .message { font-size: 14px; color: #475569; line-height: 1.7; margin-bottom: 25px; }

        /* Status Badge */
        .status-badge { display: inline-block; padding: 8px 16px; border-radius: 50px; font-weight: 700; font-size: 13px; }
        .status-confirmed { background: #dbeafe; color: #1e40af; }
        .status-cancelled { background: #fee2e2; color: #b91c1c; }
        .status-processing { background: #fef3c7; color: #92400e; }
        .status-shipped { background: #e0f2fe; color: #0369a1; }
        .status-delivered { background: #dcfce7; color: #166534; }

        /* Order Summary Box */
        .order-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px 25px; margin-bottom: 25px; }
        .order-row { display: flex; justify-content: space-between; font-size: 13px; padding: 6px 0; border-bottom: 1px solid #f1f5f9; color: #475569; }
        .order-row:last-child { border-bottom: none; font-weight: 700; color: #1e293b; font-size: 14px; }
        .order-row span:first-child { color: #64748b; }

        /* CTA Button */
        .btn-center { text-align: center; margin-top: 25px; }
        .btn { display: inline-block; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: #ffffff !important; text-decoration: none; padding: 13px 32px; border-radius: 8px; font-weight: 700; font-size: 15px; letter-spacing: 0.3px; }

        /* Footer */
        .footer { background: #f8fafc; padding: 20px 40px; text-align: center; border-top: 1px solid #e2e8f0; }
        .footer p { font-size: 12px; color: #94a3b8; line-height: 1.6; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        <div class="header">
            <h1>Order Update</h1>
            <p>Order #{{ $order->order_number }}</p>
        </div>

        <div class="body">
            <p class="greeting">Hello {{ $order->user->name ?? 'Customer' }},</p>
            <p class="message">
                We're writing to let you know that the status of your order has been updated. 
                Below are the latest details:
            </p>

            <div class="order-box">
                <div class="order-row">
                    <span>New Status</span>
                    <span><span class="status-badge status-{{ strtolower($status) }}">{{ ucfirst($status) }}</span></span>
                </div>
                <div class="order-row">
                    <span>Order Date</span>
                    <span>{{ $order->created_at->format('F d, Y') }}</span>
                </div>
                <div class="order-row">
                    <span>Total Amount</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
            
            <p class="message">
                If you have any questions or need further assistance, please don't hesitate to reach out to our support team.
            </p>
            
            <div class="btn-center">
                <a href="{{ route('orders.show', $order->id) }}" class="btn">View Order Details</a>
            </div>
        </div>

        <div class="footer">
            <p><strong>Faux Fire Official</strong><br>
            This is an automated message regarding your order.<br>
            &copy; {{ date('Y') }} Faux Fire Official. All rights reserved.</p>
        </div>
    </div>
</div>
</body>
</html>
