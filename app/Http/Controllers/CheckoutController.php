<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Signup;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop')->with('error', 'Your cart is empty. Add products before checking out.');
        }
        $user = Signup::find(session('user_id'));

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }
        $shipping = ($subtotal > 200) ? 0 : 15;
        $total = $subtotal + $shipping;

        return view('checkout', compact('cart', 'subtotal', 'shipping', 'total', 'user'));
    }

    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:25',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
        ]);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }
        $shipping = ($subtotal > 200) ? 0 : 15;
        $total = $subtotal + $shipping;

        $order = Order::create([
            'user_id' => session('user_id'),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'country' => $request->country ?? 'United States',
            'address' => $request->address,
            'city' => $request->city,
            'order_notes' => $request->order_notes,
            'subtotal' => $subtotal,
            'shipping_fee' => $shipping,
            'total_amount' => $total,
            'payment_method' => $request->payment_method ?? 'Cash on Delivery',
            'status' => 'pending',
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);

            // Automatically decrement product inventory stock
            $product = Product::find($productId);
            if ($product) {
                $product->stock_quantity = max(0, (int)$product->stock_quantity - (int)$item['quantity']);
                if ($product->stock_quantity <= 0) {
                    $product->stock_status = 'Out of Stock';
                }
                $product->save();
            }
        }

        // If Credit Card, redirect to Stripe Checkout Sandbox
        if ($request->payment_method === 'Credit Card') {
            try {
                Stripe::setApiKey(config('services.stripe.secret'));

                $lineItems = [];
                foreach ($cart as $item) {
                    $lineItems[] = [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => $item['name'],
                            ],
                            'unit_amount' => (int) round($item['price'] * 100),
                        ],
                        'quantity' => $item['quantity'],
                    ];
                }

                if ($shipping > 0) {
                    $lineItems[] = [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Standard Shipping',
                            ],
                            'unit_amount' => (int) round($shipping * 100),
                        ],
                        'quantity' => 1,
                    ];
                }

                $checkoutSession = StripeSession::create([
                    'payment_method_types' => ['card'],
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'customer_email' => $request->email,
                    'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order->id,
                    'cancel_url' => route('stripe.cancel') . '?order_id=' . $order->id,
                ]);

                return redirect($checkoutSession->url);

            } catch (\Exception $e) {
                // Restore stock if Stripe initialization failed
                foreach ($cart as $productId => $item) {
                    $product = Product::find($productId);
                    if ($product) {
                        $product->stock_quantity += (int)$item['quantity'];
                        if ($product->stock_quantity > 0) {
                            $product->stock_status = 'In Stock';
                        }
                        $product->save();
                    }
                }
                $order->delete();
                return redirect()->route('checkout')->with('error', 'Stripe payment error: ' . $e->getMessage());
            }
        }

        // Offline payment methods
        session()->forget('cart');

        return redirect()->route('dashboard')->with('message', 'Thank you! Your order #' . $order->id . ' has been placed successfully.');
    }

    public function stripeSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        $sessionId = $request->query('session_id');

        if (!$orderId) {
            return redirect()->route('shop')->with('error', 'Invalid order details.');
        }

        $order = Order::where('id', $orderId)
            ->where('user_id', session('user_id'))
            ->first();

        if (!$order) {
            return redirect()->route('dashboard')->with('error', 'Order not found.');
        }

        if ($sessionId) {
            try {
                Stripe::setApiKey(config('services.stripe.secret'));
                $session = StripeSession::retrieve($sessionId);
                if ($session->payment_status === 'paid') {
                    $order->status = 'completed';
                    $order->save();
                }
            } catch (\Exception $e) {
                $order->status = 'completed';
                $order->save();
            }
        } else {
            $order->status = 'completed';
            $order->save();
        }

        session()->forget('cart');

        return redirect()->route('dashboard')->with('message', 'Payment successful! Your order #' . $order->id . ' has been placed.');
    }

    public function stripeCancel(Request $request)
    {
        $orderId = $request->query('order_id');
        if ($orderId) {
            $order = Order::with('items')->where('id', $orderId)
                ->where('user_id', session('user_id'))
                ->where('status', 'pending')
                ->first();
            if ($order) {
                $order->status = 'cancelled';
                $order->save();

                // Restore stock for cancelled order
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->stock_quantity += (int)$item->quantity;
                        if ($product->stock_quantity > 0) {
                            $product->stock_status = 'In Stock';
                        }
                        $product->save();
                    }
                }
            }
        }

        return redirect()->route('checkout')->with('error', 'Card payment was cancelled. You can try again or choose another payment method.');
    }
}


