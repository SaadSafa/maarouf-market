@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')
  <script>
    setInterval(() => {
        location.reload();
    }, 5000);
</script>
<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">Orders</h1>
    </div>

    <!-- Tabs -->
    <div class="flex gap-8 border-b">
        <a href="{{ route('admin.orders.index', ['tab' => 'current']) }}"
           class="pb-3 {{ $tab === 'current' ? 'border-b-2 border-emerald-600 text-emerald-600 font-semibold' : 'text-slate-500' }}">
            Current
        </a>

        <a href="{{ route('admin.orders.index', ['tab' => 'history']) }}"
           class="pb-3 {{ $tab === 'history' ? 'border-b-2 border-emerald-600 text-emerald-600 font-semibold' : 'text-slate-500' }}">
            History
        </a>

        <a href="{{ route('admin.orders.index', ['tab' => 'pending']) }}"
           class="pb-3 {{ $tab === 'pending' ? 'border-b-2 border-emerald-600 text-emerald-600 font-semibold' : 'text-slate-500' }}">
            Pending
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4">

        <div class="flex items-center justify-between pb-4">

            <!-- Refresh -->
            <button onclick="location.reload()" class="text-slate-500 hover:text-slate-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 4v5h.582m15.418 0V4h-5m0 16v-5h-.582M20 12H4"/>
                </svg>
            </button>

            <!-- FILTER FORM -->
            <form method="GET" class="flex gap-4 items-center">
                <input type="hidden" name="tab" value="{{ $tab }}">

                <!-- Status -->

                <select name="status" class="h-10 px-3 border border-slate-300 rounded-xl">
                    <option value="all">Status: All</option>
                    <option value="placed"     {{ request('status')=='placed'?'selected':'' }}>Placed</option>
                    <option value="picking"    {{ request('status')=='picking'?'selected':'' }}>Picking</option>
                    <option value="picked"     {{ request('status')=='picked'?'selected':'' }}>Picked</option>
                    <option value="indelivery" {{ request('status')=='indelivery'?'selected':'' }}>In Delivery</option>
                    <option value="completed"  {{ request('status')=='completed'?'selected':'' }}>Completed</option>
                    <option value="cancelled"   {{ request('status')=='cancelled'?'selected':'' }}>Cancelled</option>
                </select>

                <!-- Date -->
                <input type="date"
                       name="date"
                       value="{{ request('date') }}"
                       class="h-10 px-3 border border-slate-300 rounded-xl">

                <!-- Payment Filter -->
                <select name="payment_method" class="h-10 px-3 border border-slate-300 rounded-xl">
                    <option value="all">Payment Method: All</option>
                    <option value="cash" {{ request('payment_method')=='cash'?'selected':'' }}>Cash</option>
                    <option value="card" {{ request('payment_method')=='card'?'selected':'' }}>Card</option>
                </select>

                <!-- Apply -->
                <button type="submit"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700">
                    Apply
                </button>
            </form>
        </div>

        <!-- Table -->
        <!-- DESKTOP TABLE -->
<div class="hidden lg:block overflow-x-auto">
    <table class="min-w-[1100px] w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-500 border-b">
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Manager Notes</th>
                        <th class="py-3 px-4">Customer</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Arrived Store</th>
                        <th class="py-3 px-4">ETA/Elapsed Time</th>
                        <th class="py-3 px-4">Area</th>
                        <th class="py-3 px-4">Cart Info</th>
                        <th class="py-3 px-4 text-right">Pickup</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b hover:bg-slate-50">
                            <td class="py-3 px-4">{{ $order->id }}</td>
                            <td class="py-3 px-4">{{ $order->manager_notes ?? '-' }}</td>
                            <td class="py-3 px-4">{{ $order->customer_name }}</td>
                            <td class="py-3 px-4">
    @if ($tab != 'history')  
    <select id="orderStatus" class="status-select px-2 py-1 border rounded text-xs"
            data-id="{{ $order->id }}">
        @foreach(['placed','picking','picked','indelivery','completed','cancelled','pending'] as $st)
            <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>
                {{ ucfirst($st) }}
            </option>
        @endforeach
    </select>
</td>
@elseif($tab === 'history')

<span id="orderStatus" class="status-select px-2 py-1 border rounded text-xs @if ($order->status == 'completed') bgordercomplete @else bgordercanceled 
@endif"
            data-id="{{ $order->id }}">
        @foreach(['completed','cancelled'] as $st)
        @if ($st === $order->status)
         <span value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>
                {{ ucfirst($st) }}
            </span>
        @endif
        @endforeach
    </span>
</td>
@endif
                            <td class="py-3 px-4">{{ $order->created_at }}</td>
                            <td class="py-3 px-4">{{ ($order->created_at)->addMinutes(35) }}</td>
                            <td class="py-3 px-4">{{ $order->area ?? '-' }}</td>
                            <td class="py-3 px-4">-</td>

                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="text-emerald-600 text-sm">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-6 text-center text-slate-500">
                                No data found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARDS -->
<div class="lg:hidden space-y-4">

    @forelse($orders as $order)
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 space-y-3">

            <!-- Header -->
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-800">
                    Order #{{ $order->id }}
                </span>

                <span class="text-xs px-2 py-1 rounded
                    @if($order->status=='completed') bg-emerald-50 text-emerald-700
                    @elseif($order->status=='cancelled') bg-red-50 text-red-700
                    @else bg-amber-50 text-amber-700
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <!-- Customer -->
            <div class="text-sm text-slate-700">
                <span class="font-medium">Customer:</span>
                {{ $order->customer_name }}
            </div>

            <!-- Area -->
            <div class="text-sm text-slate-700">
                <span class="font-medium">Area:</span>
                {{ $order->area ?? '-' }}
            </div>

            <!-- Time -->
            <div class="text-xs text-slate-500">
                Arrived: {{ $order->created_at }} <br>
                ETA: {{ $order->created_at->addMinutes(35) }}
            </div>

            <!-- Status Change (same logic) -->
            @if($tab != 'history')
                <select
                    class="status-select w-full mt-2 px-3 py-2 border rounded-lg text-sm"
                    data-id="{{ $order->id }}">
                    @foreach(['placed','picking','picked','indelivery','completed','cancelled','pending'] as $st)
                        <option value="{{ $st }}" {{ $order->status === $st ? 'selected' : '' }}>
                            {{ ucfirst($st) }}
                        </option>
                    @endforeach
                </select>
            @endif

            <!-- Actions -->
            <div class="pt-2 flex justify-end">
                <a href="{{ route('admin.orders.show', $order) }}"
                   class="text-emerald-600 text-sm font-medium">
                    View Details →
                </a>
            </div>

        </div>
    @empty
        <div class="text-center text-slate-500 py-6">
            No data found
        </div>
    @endforelse

</div>


        <!-- Pagination -->
        <div class="p-4">
            {{ $orders->links() }}
        </div>

    </div>

</div>
@endsection
