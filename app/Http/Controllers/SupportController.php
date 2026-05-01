<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Display the support page with tickets history.
     */
    public function index()
    {
        $tickets = Ticket::where('user_id', auth()->id())->latest()->get();
        return view('support.index', compact('tickets'));
    }

    /**
     * Store a new ticket.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Ticket::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Your support ticket has been submitted successfully!');
    }

    /**
     * Show a specific ticket.
     */
    public function show($id)
    {
        $ticket = Ticket::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('support.show', compact('ticket'));
    }
}
