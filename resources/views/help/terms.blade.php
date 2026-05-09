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
                <h1 style="font-size: 42px; font-weight: 800; color: #1e293b;">Terms & Conditions</h1>
                <p style="color: #64748b; font-size: 18px;">Our rules and guidelines for using this website.</p>
            </div>

            <div class="policy-content">
                <p>Welcome to our website. If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use.</p>

                <h2>1. Use of the Website</h2>
                <p>The content of the pages of this website is for your general information and use only. It is subject to change without notice.</p>
                <p>Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose.</p>

                <h2>2. Intellectual Property</h2>
                <p>This website contains material which is owned by or licensed to us. This material includes, but is not limited to, the design, layout, look, appearance and graphics. Reproduction is prohibited other than in accordance with the copyright notice, which forms part of these terms and conditions.</p>

                <h2>3. Limitation of Liability</h2>
                <p>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.</p>

                <h2>4. Governing Law</h2>
                <p>Your use of this website and any dispute arising out of such use of the website is subject to the laws of our jurisdiction.</p>

                <h2>5. Termination</h2>
                <p>We may terminate or suspend access to our service immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.</p>
            </div>
        </div>
    </div>
</main>
@endsection
