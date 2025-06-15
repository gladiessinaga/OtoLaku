<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('user.faq', compact('faqs'));
    }

    public function show($id)
    {
        $faqs = Faq::all();
        $faqDetail = Faq::findOrFail($id);
        return view('user.faq', compact('faqs', 'faqDetail'));
    }
}
