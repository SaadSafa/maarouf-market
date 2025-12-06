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
            $query->whereIn('status', ['completed', 'canceled']);
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
public function items(Order $order) {
    return $order->items()->with('product')->get();
}



    // ---------------------------
    // AJAX: UPDATE STATUS
    // ---------------------------
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:placed,picking,picked,indelivery,completed,canceled,pending'
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

        $item = $order->items()->create([
            'product_id'    => $product->id,
            'quantity'      => $request->quantity,
            'price' => $product->price,    // FIXED HERE
        ]);

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





public function updateItem(Request $request, OrderItem $item) {
try{
    
    \Log::info("ADD ITEM DEBUG", [
            'order_id' => $item->qty,
            'request'  => $request->all()
        ]);
    $item->update(['quantity' => $request->quantity]);

  return response()->json([
    'items' => $item->order->items()->with('product')->get()
    
]);
}
catch(Exception $e){

      \Log::error("ADD ITEM ERROR", [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
}

}


public function deleteItem(OrderItem $item) {

    $order = $item->order;

    $item->delete();

   return response()->json([
    'items' => $order->items()->with('product')->get()
]);

}

public function GetPendingOrders(){

    $count = Order::whereNotIn('status', ['completed', 'canceled'])->count();

    return response()->json([
        'PendingOrders' => $count
    ]);
}

}
