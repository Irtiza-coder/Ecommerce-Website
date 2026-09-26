<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }
        $shipping = ($subtotal > 200 || $subtotal == 0) ? 0 : 15;
        $total = $subtotal + $shipping;

        return view('cart', compact('cart', 'subtotal', 'shipping', 'total'));
    }
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->stock_quantity <= 0 || $product->stock_status === 'Out of Stock') {
            return redirect()->back()->with('error', "Sorry, {$product->name} is currently out of stock.");
        }

        $cart = session()->get('cart', []);
        $qty = max(1, (int) $request->input('quantity', 1));

        $currentQtyInCart = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        if (($currentQtyInCart + $qty) > $product->stock_quantity) {
            $available = $product->stock_quantity - $currentQtyInCart;
            if ($available <= 0) {
                return redirect()->back()->with('error', "You already have the maximum available stock ({$product->stock_quantity}) in your cart.");
            }
            $qty = $available;
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => $qty,
                'image' => $product->image_url,
                'slug' => $product->slug,
            ];
        }
        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('message', "{$product->name} added to cart!");
    }
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $change = (int) $request->input('change', 0);
            $newQty = $cart[$id]['quantity'] + $change;
            $product = Product::find($id);

            if ($product && $newQty > $product->stock_quantity) {
                return redirect()->route('cart.index')->with('error', "Only {$product->stock_quantity} units available for {$product->name}.");
            }

            if ($newQty > 0) {
                $cart[$id]['quantity'] = $newQty;
            } else {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('message', 'Cart updated successfully.');
    }
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('message', 'Item removed from cart.');
    }
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('message', 'Cart cleared.');
    }
}
