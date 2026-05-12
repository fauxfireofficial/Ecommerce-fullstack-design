<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Review;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function updateStatus(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $request->validate(['status' => 'required|in:pending,approved,rejected']);
        
        $review->update(['status' => $request->status]);
        
        return back()->with('success', 'Review status updated to ' . $request->status);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        
        // Delete associated images from storage
        if ($review->images) {
            foreach ($review->images as $img) {
                $filePath = str_replace('storage/', '', $img);
                Storage::disk('public')->delete($filePath);
            }
        }
        
        $review->delete();
        
        return back()->with('success', 'Review deleted successfully.');
    }

    public function reply(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $request->validate(['admin_reply' => 'required|string']);
        
        $review->update(['admin_reply' => $request->admin_reply]);
        
        return back()->with('success', 'Reply saved successfully!');
    }
}
