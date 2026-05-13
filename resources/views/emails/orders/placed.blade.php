<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmed</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f4f8; padding: 30px 20px; }
        .wrapper { max-width: 620px; margin: 0 auto; }
        .card { background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }

        /* Header */
        .header { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); padding: 40px 40px 30px; text-align: center; }
        .header .icon { font-size: 48px; margin-bottom: 12px; }
        .header h1 { color: #ffffff; font-size: 26px; font-weight: 700; margin-bottom: 6px; }
        .header p { color: rgba(255,255,255,0.85); font-size: 14px; }

        /* Body */
        .body { padding: 35px 40px; }
        .greeting { font-size: 16px; color: #1e293b; margin-bottom: 12px; font-weight: 600; }
        .message { font-size: 14px; color: #475569; line-height: 1.7; margin-bottom: 25px; }

        /* Order Summary Box */
        .order-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px 25px; margin-bottom: 25px; }
        .order-box .order-id { font-size: 20px; font-weight: 700; color: #1e40af; margin-bottom: 15px; }
        .order-row { display: flex; justify-content: space-between; font-size: 13px; padding: 6px 0; border-bottom: 1px solid #f1f5f9; color: #475569; }
        .order-row:last-child { border-bottom: none; font-weight: 700; color: #1e293b; font-size: 14px; }
        .order-row span:first-child { color: #64748b; }

        /* Items */
        .items-title { font-size: 14px; font-weight: 700; color: #1e293b; margin-bottom: 12px; }
        .item-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: #475569; }
        .item-row:last-child { border-bottom: none; }
        .item-name { font-weight: 600; color: #334155; }

        /* Status badge */
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #dbeafe; color: #1e40af; }

        /* CTA Button */
        .btn-center { text-align: center; margin: 25px 0 10px; }
        .btn { display: inline-block; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: #ffffff; text-decoration: none; padding: 13px 32px; border-radius: 8px; font-weight: 700; font-size: 15px; letter-spacing: 0.3px; }

        /* Footer */
        .footer { background: #f8fafc; padding: 20px 40px; text-align: center; border-top: 1px solid #e2e8f0; }
        .footer p { font-size: 12px; color: #94a3b8; line-height: 1.6; }
        .footer strong { color: #475569; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        <!-- Header -->
        <div class="header">
            <h1>Order Confirmed!</h1>
            <p>Thank you for shopping with us</p>
        </div>

        <!-- Body -->
        <div class="body">
            <p class="greeting">Hello {{ $order->user->name ?? $order->email }},</p>
            <p class="message">
                Great news! Your order has been successfully placed and is now being prepared.
                We'll notify you as soon as it's on its way. Below is a summary of your order:
            </p>

            <!-- Order Summary -->
            <div class="order-box">
                <div class="order-id">#{{ $order->order_number }}</div>
                <div class="order-row">
                    <span>Order Date</span>
                    <span>{{ $order->created_at->format('F d, Y \a\t h:i A') }}</span>
                </div>
                <div class="order-row">
                    <span>Status</span>
                    <span><span class="badge">{{ ucfirst($order->status) }}</span></span>
                </div>
                <div class="order-row">
                    <span>Shipping To</span>
                    <span>{{ $order->shipping_address }}</span>
                </div>
                <div class="order-row">
                    <span>Payment Status</span>
                    <span>{{ ucfirst($order->payment_status) }}</span>
                </div>
                <div class="order-row">
                    <span>Total Amount</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <!-- Items -->
            @if($order->items && $order->items->count() > 0)
            <p class="items-title">Items Ordered</p>
            @foreach($order->items as $item)
            <div class="item-row">
                <span class="item-name">{{ $item->product->name ?? 'Product' }}</span>
                <span>x{{ $item->quantity }} &nbsp; ${{ number_format($item->price, 2) }}</span>
            </div>
            @endforeach
            @endif

            <div class="btn-center">
                <a href="{{ route('orders.show', $order->id) }}" class="btn">View My Order</a>
            </div>

            <p class="message" style="margin-top: 20px; font-size: 13px;">
                If you have any questions about your order, feel free to reach out to our support team.
                We're here to help!
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Faux Fire Official</strong><br>
            This is an automated email. Please do not reply directly to this message.<br>
            &copy; {{ date('Y') }} Faux Fire Official. All rights reserved.</p>
        </div>
    </div>
</div>
</body>
</html>
