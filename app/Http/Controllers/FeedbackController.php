<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function create()
{
    return view('user.feedback');
}

public function store(Request $request)
{
    $request->validate([
        'kategori' => 'required|string|max:50',
        'pesan' => 'required|string|max:1000',
    ]);

    Feedback::create([
        'user_id' => Auth::id(),
        'kategori' => $request->kategori,
        'pesan' => $request->pesan,
    ]);

    return redirect()->route('feedback.store')->with('success', 'Terima kasih atas feedback Anda!');
}

public function index()
{
    $feedbacks = Feedback::with('user')->latest()->get();
    return view('admin.feedbackd', compact('feedbacks'));
}
}
