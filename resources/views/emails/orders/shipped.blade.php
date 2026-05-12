<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Shipped</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f0f4f8; padding: 30px 20px; }
        .wrapper { max-width: 620px; margin: 0 auto; }
        .card { background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }

        /* Header */
        .header { background: linear-gradient(135deg, #065f46 0%, #10b981 100%); padding: 40px 40px 30px; text-align: center; }
        .header .icon { font-size: 48px; margin-bottom: 12px; }
        .header h1 { color: #ffffff; font-size: 26px; font-weight: 700; margin-bottom: 6px; }
        .header p { color: rgba(255,255,255,0.85); font-size: 14px; }

        /* Body */
        .body { padding: 35px 40px; }
        .greeting { font-size: 16px; color: #1e293b; margin-bottom: 12px; font-weight: 600; }
        .message { font-size: 14px; color: #475569; line-height: 1.7; margin-bottom: 25px; }

        /* Tracking Banner */
        .tracking-banner { background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1px solid #6ee7b7; border-radius: 10px; padding: 20px 25px; margin-bottom: 25px; text-align: center; }
        .tracking-banner .truck { font-size: 36px; margin-bottom: 8px; }
        .tracking-banner h3 { font-size: 17px; font-weight: 700; color: #065f46; margin-bottom: 4px; }
        .tracking-banner p { font-size: 13px; color: #047857; }

        /* Timeline */
        .timeline { margin: 20px 0 25px; }
        .timeline-step { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
        .timeline-dot { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
        .dot-done { background: #10b981; color: white; }
        .dot-active { background: #3b82f6; color: white; }
        .dot-pending { background: #e2e8f0; color: #94a3b8; }
        .timeline-label { font-size: 13px; }
        .timeline-label strong { display: block; color: #1e293b; font-weight: 600; }
        .timeline-label span { color: #94a3b8; font-size: 12px; }

        /* Order Box */
        .order-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px 25px; margin-bottom: 25px; }
        .order-box .order-id { font-size: 18px; font-weight: 700; color: #065f46; margin-bottom: 15px; }
        .order-row { display: flex; justify-content: space-between; font-size: 13px; padding: 6px 0; border-bottom: 1px solid #f1f5f9; color: #475569; }
        .order-row:last-child { border-bottom: none; font-weight: 700; color: #1e293b; font-size: 14px; }
        .order-row span:first-child { color: #64748b; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #d1fae5; color: #065f46; }

        /* CTA Button */
        .btn-center { text-align: center; margin: 25px 0 10px; }
        .btn { display: inline-block; background: linear-gradient(135deg, #065f46 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 13px 32px; border-radius: 8px; font-weight: 700; font-size: 15px; }

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
            <div class="icon">🚚</div>
            <h1>Your Order is On Its Way!</h1>
            <p>Sit tight — your package is heading to you</p>
        </div>

        <!-- Body -->
        <div class="body">
            <p class="greeting">Hello {{ $order->user->name ?? $order->email }},</p>
            <p class="message">
                Exciting news! Your order has been shipped and is now on its way to you.
                Keep an eye out for your delivery!
            </p>

            <!-- Tracking Banner -->
            <div class="tracking-banner">
                <div class="truck">📦</div>
                <h3>Package Dispatched</h3>
                <p>Your order is en route — estimated delivery within 3–7 business days</p>
            </div>

            <!-- Delivery Timeline -->
            <div class="timeline">
                <div class="timeline-step">
                    <div class="timeline-dot dot-done">✓</div>
                    <div class="timeline-label">
                        <strong>Order Placed</strong>
                        <span>{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
                <div class="timeline-step">
                    <div class="timeline-dot dot-done">✓</div>
                    <div class="timeline-label">
                        <strong>Order Confirmed</strong>
                        <span>Processing complete</span>
                    </div>
                </div>
                <div class="timeline-step">
                    <div class="timeline-dot dot-active">🚚</div>
                    <div class="timeline-label">
                        <strong>Shipped</strong>
                        <span>Your package is on its way!</span>
                    </div>
                </div>
                <div class="timeline-step">
                    <div class="timeline-dot dot-pending">📍</div>
                    <div class="timeline-label">
                        <strong>Delivered</strong>
                        <span>Expected within 3–7 business days</span>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="order-box">
                <div class="order-id">#{{ $order->order_number }}</div>
                <div class="order-row">
                    <span>Shipping To</span>
                    <span>{{ $order->shipping_address }}</span>
                </div>
                <div class="order-row">
                    <span>Status</span>
                    <span><span class="badge">Shipped</span></span>
                </div>
                <div class="order-row">
                    <span>Total Amount</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <div class="btn-center">
                <a href="{{ route('orders.show', $order->id) }}" class="btn">Track My Order</a>
            </div>

            <p class="message" style="margin-top: 20px; font-size: 13px;">
                If you have any questions about your delivery, feel free to contact our support team.
                We're always happy to help!
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
