<?php

namespace App\Http\Controllers;

use App\Models\GiftBox;
use App\Models\Product;
use Illuminate\Http\Request;

class GiftBoxController extends Controller
{
    /**
     * Handle adding a personalized gift box to the cart.
     * Generates a unique cart key based on customization to allow multiple versions of the same box.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'gift_box_id' => 'required|exists:gift_boxes,id',
            'gift_to' => 'nullable|string|max:100',
            'gift_from' => 'nullable|string|max:100',
            'gift_message' => 'nullable|string|max:500',
            'wrapping_color' => 'required|string',
            'quantity' => 'required|integer|min:1|max:10',
            'include_receipt' => 'nullable',
        ]);

        $giftBox = GiftBox::findOrFail($request->gift_box_id);
        
        $cart = session()->get('cart', []);
        
        // Create a unique key for this customized gift box to allow different messages for the same box type
        $uniqueKey = 'gift_' . $giftBox->id . '_' . md5(($request->gift_message ?? '') . ($request->wrapping_color ?? '') . ($request->gift_to ?? '') . ($request->gift_from ?? ''));
        
        $qtyToAdd = (int) $request->quantity;

        if(isset($cart[$uniqueKey])) {
            $cart[$uniqueKey]['quantity'] += $qtyToAdd;
        } else {
            $cart[$uniqueKey] = [
                "name" => $giftBox->name,
                "quantity" => $qtyToAdd,
                "price" => (float)$giftBox->base_price,
                "image" => $giftBox->image,
                "is_gift" => true,
                "gift_box_id" => $giftBox->id,
                "gift_to" => $request->gift_to,
                "gift_from" => $request->gift_from,
                "gift_message" => $request->gift_message,
                "wrapping_color" => $request->wrapping_color,
                "include_receipt" => $request->has('include_receipt')
            ];
        }

        session()->put('cart', $cart);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Custom Gift Box added to cart!',
            'cartCount' => count($cart)
        ]);
    }
}
