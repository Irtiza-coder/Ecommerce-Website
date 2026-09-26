<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = session()->get('wishlist', []);
        $products = Product::whereIn('id', $wishlist)->get();

        return view('wishlist', compact('products'));
    }

    public function toggle($id)
    {
        $product = Product::findOrFail($id);
        $wishlist = session()->get('wishlist', []);

        if (in_array($id, $wishlist)) {
            $wishlist = array_values(array_diff($wishlist, [$id]));
            $message = "{$product->name} removed from your wishlist.";
        } else {
            $wishlist[] = (int) $id;
            $message = "{$product->name} added to your wishlist!";
        }

        session()->put('wishlist', $wishlist);

        return redirect()->back()->with('message', $message);
    }

    public function remove($id)
    {
        $wishlist = session()->get('wishlist', []);
        $wishlist = array_values(array_diff($wishlist, [$id]));
        session()->put('wishlist', $wishlist);

        return redirect()->route('wishlist.index')->with('message', 'Item removed from wishlist.');
    }
}
