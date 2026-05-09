@extends('layouts.app')

@section('styles')
<style>
    .help-page {
        padding: 80px 0;
        background: #f8fafc;
    }
    .help-container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 50px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .help-header {
        text-align: center;
        margin-bottom: 50px;
    }
    .help-header h1 {
        font-size: 36px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 15px;
    }
    .help-header p {
        color: #64748b;
        font-size: 18px;
    }
    .faq-item {
        margin-bottom: 25px;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 25px;
    }
    .faq-item:last-child {
        border-bottom: none;
    }
    .faq-question {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .faq-question i {
        color: #3b82f6;
    }
    .faq-answer {
        color: #475569;
        line-height: 1.6;
        font-size: 15px;
    }
</style>
@endsection

@section('content')
<main class="help-page">
    <div class="container">
        <div class="help-container">
            <div class="help-header">
                <h1>Frequently Asked Questions</h1>
                <p>Find answers to common questions about our services and policies.</p>
            </div>

            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-question"><i class="fa-solid fa-circle-question"></i> How do I track my order?</div>
                    <div class="faq-answer">
                        You can track your order by clicking on the "Track Order" link in the Help dropdown menu or by visiting your profile dashboard if you are a registered user.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question"><i class="fa-solid fa-circle-question"></i> What is your return policy?</div>
                    <div class="faq-answer">
                        We offer a 30-day return policy for most items. The items must be in their original packaging and unused. Please visit our Return Policy page for more details.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question"><i class="fa-solid fa-circle-question"></i> Do you ship internationally?</div>
                    <div class="faq-answer">
                        Yes, we ship to over 50 countries worldwide. Shipping costs and delivery times vary depending on your location.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question"><i class="fa-solid fa-circle-question"></i> How can I contact customer support?</div>
                    <div class="faq-answer">
                        You can reach our support team through the Contact Us page or by emailing support@brand.com. We typically respond within 24 hours.
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
