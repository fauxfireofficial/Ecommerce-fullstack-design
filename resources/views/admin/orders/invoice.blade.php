<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 40px;
            color: #333;
            line-height: 1.6;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            background: #fff;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #0d6efd;
            font-size: 32px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        .info-box h3 {
            margin-top: 0;
            font-size: 14px;
            text-transform: uppercase;
            color: #777;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table th {
            background: #f8f9fa;
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #eee;
            font-size: 13px;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .totals {
            margin-left: auto;
            width: 300px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }
        .total-row.grand-total {
            border-top: 2px solid #eee;
            margin-top: 10px;
            padding-top: 10px;
            font-weight: bold;
            font-size: 18px;
            color: #0d6efd;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #999;
            font-size: 12px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
            .invoice-box {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: right; margin-bottom: 20px; max-width: 800px; margin: 0 auto 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #0d6efd; color: white; border: none; border-radius: 4px; cursor: pointer;">Print Invoice</button>
    </div>

    <div class="invoice-box">
        <div class="header">
            <div>
                <h1>INVOICE</h1>
                <p>Order ID: #{{ $order->id }}</p>
                <p>Date: {{ $order->created_at->format('M d, Y') }}</p>
            </div>
            <div style="text-align: right;">
                <h2 style="margin: 0;">BRAND STORE</h2>
                <p>123 Commerce St, Tech City<br>
                contact@brandstore.com<br>
                +1 (555) 000-0000</p>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-box">
                <h3>Billed To:</h3>
                <strong>{{ $order->user->name ?? 'Guest User' }}</strong><br>
                {{ $order->user->email ?? '' }}<br>
                {{ $order->shipping_phone }}
            </div>
            <div class="info-box">
                <h3>Shipping Address:</h3>
                {{ $order->shipping_address }}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Product' }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td style="text-align: right;">${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="total-row">
                <span>Shipping:</span>
                <span>${{ number_format($order->shipping_cost, 2) }}</span>
            </div>
            <div class="total-row">
                <span>Tax:</span>
                <span>${{ number_format($order->tax, 2) }}</span>
            </div>
            <div class="total-row grand-total">
                <span>Total:</span>
                <span>${{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>This is a computer-generated invoice and does not require a signature.</p>
        </div>
    </div>
</body>
</html>
