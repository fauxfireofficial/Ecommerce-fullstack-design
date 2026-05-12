<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Review;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        $productId = $request->product_id;

        // Check if user already reviewed
        $existingReview = Review::where('product_id', $request->product_id)
                               ->where('user_id', auth()->id())
                               ->first();
        
        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        // Verify if user has purchased the product
        $hasPurchased = OrderItem::whereHas('order', function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->whereIn('status', ['completed', 'delivered', 'processing']);
            })
            ->where('product_id', $productId)
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Only verified purchasers can leave a review.');
        }

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', $user->id)
                                ->where('product_id', $productId)
                                ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product. You can edit your existing review.');
        }

        $reviewImages = [];
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $file) {
                $path = $file->store('reviews', 'public');
                $reviewImages[] = 'storage/' . $path;
            }
        }

        Review::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => $reviewImages,
            'status' => 'approved',
        ]);

        return back()->with('success', 'Thank you for your review!');
    }

    public function update(Request $request, $id)
    {
        $review = Review::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $currentImages = $review->images ?? [];
        
        // Remove selected images
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imgToRemove) {
                if (($key = array_search($imgToRemove, $currentImages)) !== false) {
                    // Delete file from storage
                    $filePath = str_replace('storage/', '', $imgToRemove);
                    Storage::disk('public')->delete($filePath);
                    unset($currentImages[$key]);
                }
            }
        }

        // Add new images
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            if (count($currentImages) + count($files) > 3) {
                return back()->with('error', 'Maximum 3 photos allowed per review.');
            }

            foreach ($files as $file) {
                $path = $file->store('reviews', 'public');
                $currentImages[] = 'storage/' . $path;
            }
        }

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => array_values($currentImages),
        ]);

        return back()->with('success', 'Review updated successfully!');
    }
}
