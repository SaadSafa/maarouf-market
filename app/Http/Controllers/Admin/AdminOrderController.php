<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Laravel\Pail\ValueObjects\Origin\Console;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    // ---------------------------
    // ORDERS LIST PAGE
    // ---------------------------
    public function index(Request $request)
    {
        $query = Order::query();

        // TAB LOGIC
        $tab = $request->get('tab', 'current');

        if ($tab === 'current') {
            $query->whereIn('status', ['placed', 'picking', 'picked', 'indelivery']);
        } elseif ($tab === 'history') {
            $query->whereIn('status', ['completed', 'cancelled']);
        } elseif ($tab === 'pending') {
            $query->where('status', 'pending');
        }

        // SEARCH
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_code', 'like', "%$search%")
                  ->orWhere('customer_name', 'like', "%$search%")
                  ->orWhere('customer_phone', 'like', "%$search%");
            });
        }

        // STATUS FILTER
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // DATE FILTER
        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // PAYMENT METHOD
        if ($request->payment_method && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }

        // PAGINATION
        $orders = $query->latest()->paginate(10)->appends($request->query());

        return view('admin.orders.index', compact('orders', 'tab'));
    }

    //----------------------------
    //order-refresh
    //----------------------------

    public function refreshOrder(Request $request)
{
    if ($request->tab === 'history') {
        // HISTORY = completed + cancelled
        $orders = Order::whereIn('status', ['completed', 'cancelled'])->get();
    } else {
        // NORMAL = everything else
        $orders = Order::whereNotIn('status', ['completed', 'cancelled'])->get();
    }

    return response()->json([
        'success' => true,
        'data' => $orders
    ]);
}



    // ---------------------------
    // VIEW ORDER PAGE
    // ---------------------------
    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }


    // ---------------------------
    // AJAX: GET ORDER ITEMS
    // ---------------------------
    public function getItems(Order $order)
    {
        return $order->items()->with('product')->get();
    }



    // ---------------------------
    // AJAX: UPDATE STATUS
    // ---------------------------
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:placed,picking,picked,indelivery,completed,cancelled,pending'
        ]);

        $order->status = $request->status;
        $order->save();

        return response()->json([
            'success' => true,
            'updated_status' => $order->status
        ]);
    }

public function addItem(Request $request, Order $order)
{
    try {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;

        if ($product->stock !== null && $product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'error' => 'Insufficient stock for this product.'
            ], 422);
        }

        $item = $order->items()->create([
            'product_id'    => $product->id,
            'quantity'      => $quantity,
            'price' => $product->effective_price,
        ]);

        if ($product->stock !== null) {
            $product->decrement('stock', $quantity);
        }

        $this->updateOrderTotal($order);

        return response()->json([
            'success' => true,
            'items'   => $order->items()->with('product')->get()
        ]);

    } catch (Exception $e) {

        \Log::error("ADD ITEM ERROR", [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);

        return response()->json([
            'success' => false,
            'error'   => $e->getMessage()
        ], 500);
    }
    
}





    public function updateItem(Request $request, OrderItem $item)
    {
        try {
            $validated = $request->validate([
                'quantity' => ['required', 'integer', 'min:1'],
            ]);

            $quantity = (int) $validated['quantity'];
            $currentQuantity = (int) $item->quantity;
            $delta = $quantity - $currentQuantity;
            $product = $item->product()->first();

            if ($product && $delta > 0 && $product->stock !== null && $product->stock < $delta) {
                return response()->json([
                    'success' => false,
                    'error' => 'Insufficient stock for this product.'
                ], 422);
            }

            \Log::info('ORDER ITEM UPDATE', [
                'order_id' => $item->order_id,
                'product_id' => $item->product_id,
                'request' => $request->all(),
            ]);

            $item->update(['quantity' => $quantity]);

            if ($product && $product->stock !== null && $delta !== 0) {
                if ($delta > 0) {
                    $product->decrement('stock', $delta);
                } else {
                    $product->increment('stock', abs($delta));
                }
            }

            $this->updateOrderTotal($item->order);

            return response()->json([
                'items' => $item->order->items()->with('product')->get(),
            ]);
        } catch (Exception $e) {
            \Log::error('ORDER ITEM UPDATE ERROR', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }


public function deleteItem(OrderItem $item) {

    $order = $item->order;
    $product = $item->product()->first();

    $item->delete();

    if ($product && $product->stock !== null) {
        $product->increment('stock', (int) $item->quantity);
    }

    $this->updateOrderTotal($order);

   return response()->json([
    'items' => $order->items()->with('product')->get()
]);

}

public function GetPendingOrders(){

    $count = Order::whereNotIn('status', ['completed', 'cancelled'])->count();

    return response()->json([
        'PendingOrders' => $count
    ]);
}

private function updateOrderTotal(Order $order): void
{
    $total = $order->items()
        ->get()
        ->sum(function ($item) {
            return $item->quantity * $item->price;
        });

    $order->total = $total;
    $order->save();
}

}
