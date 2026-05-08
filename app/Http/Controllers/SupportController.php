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
            'subject' => 'required|string|min:5|max:255',
            'category' => 'required|string',
            'order_id' => 'nullable|string|max:100',
            'message' => 'required|string',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('tickets/attachments', 'public');
        }

        Ticket::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'category' => $request->category,
            'order_id' => $request->order_id,
            'message' => $request->message,
            'attachment' => $attachmentPath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Thank you for contacting us, ' . auth()->user()->name . '! Your ticket has been generated. Our team will get back to you within 24 hours.');
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
