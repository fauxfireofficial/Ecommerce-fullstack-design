<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function faq()
    {
        return view('help.faq');
    }

    public function returnPolicy()
    {
        return view('help.policy');
    }

    public function privacyPolicy()
    {
        return view('help.privacy');
    }

    public function termsConditions()
    {
        return view('help.terms');
    }
}
