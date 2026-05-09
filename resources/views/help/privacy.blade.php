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
</style>
@endsection

@section('content')
<main class="help-page">
    <div class="container">
        <div class="help-container">
            <div style="text-align: center; margin-bottom: 50px;">
                <h1 style="font-size: 42px; font-weight: 800; color: #1e293b;">Privacy Policy</h1>
                <p style="color: #64748b; font-size: 18px;">How we protect your data and privacy.</p>
            </div>

            <div class="policy-content">
                <p>This Privacy Policy describes how your personal information is collected, used, and shared when you visit or make a purchase from our store.</p>

                <h2>1. Information We Collect</h2>
                <p>When you visit the site, we automatically collect certain information about your device, including information about your web browser, IP address, time zone, and some of the cookies that are installed on your device.</p>
                <p>Additionally, as you browse the site, we collect information about the individual web pages or products that you view, what websites or search terms referred you to the site, and information about how you interact with the site.</p>

                <h2>2. How We Use Your Information</h2>
                <p>We use the order information that we collect generally to fulfill any orders placed through the site (including processing your payment information, arranging for shipping, and providing you with invoices and/or order confirmations).</p>

                <h2>3. Sharing Your Personal Information</h2>
                <p>We share your Personal Information with third parties to help us use your Personal Information, as described above. For example, we use Shopify to power our online store. We also use Google Analytics to help us understand how our customers use the site.</p>

                <h2>4. Data Retention</h2>
                <p>When you place an order through the site, we will maintain your order information for our records unless and until you ask us to delete this information.</p>

                <h2>5. Changes</h2>
                <p>We may update this privacy policy from time to time in order to reflect, for example, changes to our practices or for other operational, legal or regulatory reasons.</p>
            </div>
        </div>
    </div>
</main>
@endsection
