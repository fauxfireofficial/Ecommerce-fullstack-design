@extends('layouts.app')

@section('styles')
<style>
    .help-page {
        padding: 80px 0;
        background: #f8fafc;
    }
    .help-container {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        padding: 60px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .policy-content h2 {
        font-size: 24px;
        font-weight: 800;
        color: #1e293b;
        margin: 40px 0 20px;
    }
    .policy-content p {
        color: #475569;
        line-height: 1.8;
        margin-bottom: 20px;
        font-size: 16px;
    }
    .policy-content ul {
        margin-bottom: 25px;
        padding-left: 20px;
    }
    .policy-content li {
        color: #475569;
        margin-bottom: 10px;
        line-height: 1.6;
    }
    .highlight-box {
        background: #f0f7ff;
        border-left: 4px solid #3b82f6;
        padding: 25px;
        border-radius: 8px;
        margin: 30px 0;
    }
</style>
@endsection

@section('content')
<main class="help-page">
    <div class="container">
        <div class="help-container">
            <div style="text-align: center; margin-bottom: 50px;">
                <h1 style="font-size: 42px; font-weight: 800; color: #1e293b;">Return & Refund Policy</h1>
                <p style="color: #64748b; font-size: 18px;">Everything you need to know about our return process.</p>
            </div>

            <div class="policy-content">
                <p>We want you to be completely satisfied with your purchase. If for any reason you are not happy with your order, we are here to help.</p>

                <div class="highlight-box">
                    <strong>Quick Summary:</strong> You have 30 days to return an item from the date you received it. To be eligible for a return, your item must be unused and in the same condition that you received it.
                </div>

                <h2>1. Returns Eligibility</h2>
                <p>To ensure a smooth return process, please make sure that:</p>
                <ul>
                    <li>The item is returned within 30 days of delivery.</li>
                    <li>The item is in its original packaging.</li>
                    <li>The item has not been used or damaged.</li>
                    <li>You have the receipt or proof of purchase.</li>
                </ul>

                <h2>2. Refund Process</h2>
                <p>Once we receive your item, we will inspect it and notify you that we have received your returned item. We will immediately notify you on the status of your refund after inspecting the item.</p>
                <p>If your return is approved, we will initiate a refund to your credit card (or original method of payment). You will receive the credit within a certain amount of days, depending on your card issuer's policies.</p>

                <h2>3. Shipping Costs</h2>
                <p>You will be responsible for paying for your own shipping costs for returning your item. Shipping costs are non-refundable. If you receive a refund, the cost of return shipping will be deducted from your refund.</p>

                <h2>4. Contact Us</h2>
                <p>If you have any questions on how to return your item to us, contact us at <strong>support@brand.com</strong> or visit our support center.</p>
            </div>
        </div>
    </div>
</main>
@endsection
