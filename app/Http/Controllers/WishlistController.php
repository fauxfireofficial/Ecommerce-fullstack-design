<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display a listing of the wishlist items.
     */
    public function index()
    {
        $wishlist = Wishlist::with('product')->where('user_id', auth()->id())->get();
        return view('wishlist', compact('wishlist'));
    }

    /**
     * Get latest 5 wishlist items for the drawer.
     */
    public function getLatest()
    {
        if (!auth()->check()) {
            return response()->json([]);
        }

        $wishlist = Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return response()->json($wishlist);
    }

    public function toggle(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['status' => 'error', 'message' => 'Please login first'], 401);
        }

        try {
            $productId = $request->product_id;
            $wishlistItem = Wishlist::where('user_id', auth()->id())->where('product_id', $productId)->first();

            if ($wishlistItem) {
                $wishlistItem->delete();
                $count = Wishlist::where('user_id', auth()->id())->count();
                return response()->json(['status' => 'removed', 'message' => 'Removed from wishlist', 'wishlistCount' => $count]);
            } else {
                Wishlist::create([
                    'user_id' => auth()->id(),
                    'product_id' => $productId
                ]);
                $count = Wishlist::where('user_id', auth()->id())->count();
                return response()->json(['status' => 'added', 'message' => 'Added to wishlist', 'wishlistCount' => $count]);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong. Please try again.'], 500);
        }
    }

    /**
     * Remove an item from the wishlist.
     */
    public function remove($id)
    {
        $wishlistItem = Wishlist::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $wishlistItem->delete();

        return back()->with('success', 'Item removed from wishlist');
    }
}
