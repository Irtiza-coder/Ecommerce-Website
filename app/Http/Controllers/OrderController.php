<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $query = Order::with(['items.product', 'user'])->latest();

        if ($status && in_array($status, ['pending', 'processing', 'completed', 'cancelled'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhere('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $statusCounts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.Orders.index', compact('orders', 'statusCounts', 'status', 'search'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.Orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('message', "Order #{$order->id} status updated to " . ucfirst($request->status) . ".");
    }

    public function destroy(Order $order)
    {
        $orderId = $order->id;
        $order->items()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')->with('message', "Order #{$orderId} deleted successfully.");
    }
}
