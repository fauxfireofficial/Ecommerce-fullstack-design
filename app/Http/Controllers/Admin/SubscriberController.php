<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Subscriber;
use App\Models\NewsletterTemplate;
use App\Mail\NewsletterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::query();

        // Search by email
        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active');
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $subscribers = $query->latest()->paginate(15)->withQueryString();
        
        $totalSubscribers = Subscriber::count();
        $activeSubscribers = Subscriber::where('is_active', true)->count();

        // Get saved templates
        $templates = NewsletterTemplate::latest()->get();
        
        return view('admin.subscribers.index', compact('subscribers', 'totalSubscribers', 'activeSubscribers', 'templates'));
    }

    public function sendBulkEmail(Request $request)
    {
        $request->validate([
            'emails' => 'required|array',
            'emails.*' => 'email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $emails = $request->emails;
        $subject = $request->subject;
        $messageBody = $request->message;

        // Save as template if requested
        if ($request->has('save_template')) {
            NewsletterTemplate::create([
                'subject' => $subject,
                'content' => $messageBody
            ]);
        }

        try {
            foreach ($emails as $email) {
                Mail::to($email)->send(new NewsletterMail($subject, $messageBody));
            }
            return back()->with('success', count($emails) . ' professional HTML emails have been sent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Mail server error: ' . $e->getMessage());
        }
    }

    public function deleteTemplate($id)
    {
        $template = NewsletterTemplate::findOrFail($id);
        if ($template->image) {
            Storage::disk('public')->delete($template->image);
        }
        $template->delete();

        return back()->with('success', 'Email template deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->is_active = !$subscriber->is_active;
        $subscriber->save();

        return back()->with('success', 'Subscriber status updated successfully.');
    }

    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return back()->with('success', 'Subscriber deleted successfully.');
    }

    public function exportCSV()
    {
        $subscribers = Subscriber::all();
        $csvFileName = 'subscribers_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Email', 'Status', 'Subscribed At'];

        $callback = function() use($subscribers, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($subscribers as $subscriber) {
                $row['ID']            = $subscriber->id;
                $row['Email']         = $subscriber->email;
                $row['Status']        = $subscriber->is_active ? 'Active' : 'Inactive';
                $row['Subscribed At'] = $subscriber->created_at->format('Y-m-d H:i:s');

                fputcsv($file, [$row['ID'], $row['Email'], $row['Status'], $row['Subscribed At']]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
