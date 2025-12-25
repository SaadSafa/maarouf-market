@extends('admin.layouts.app')

@section('title', "Order #{$order->id}")

@php
    $isCompleted = $order->status === 'completed';
@endphp

@section('content')

<div class="space-y-8">

    <!-- HEADER -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Order #{{ $order->id }}</h1>
            <p class="text-slate-500 mt-1">Order details & cart management</p>
        </div>

        <!-- STATUS DROPDOWN -->
        <div>
            <label class="text-sm text-slate-600">Status:</label>
            <select id="orderStatus"
        data-id="{{ $order->id }}"
        class="px-3 py-2 border rounded-xl text-sm
               {{ $isCompleted ? 'bg-slate-100 cursor-not-allowed opacity-70' : '' }}"
        {{ $isCompleted ? 'disabled' : '' }}>
                @foreach(['pending','placed','picking','picked','indelivery','completed','cancelled'] as $st)
                    <option value="{{ $st }}" {{ $order->status == $st ? 'selected' : '' }}>
                        {{ ucfirst($st) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- ITEMS CARD -->
    <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
        <h2 class="text-xl font-bold mb-4">Cart Items</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-500 border-b">
                        <th class="py-3 px-4">Image</th>
                        <th class="py-3 px-4">Product</th>
                        <th class="py-3 px-4">Price</th>
                        <th class="py-3 px-4 text-center">Qty</th>
                        <th class="py-3 px-4 text-right">Subtotal</th>
                        <th class="py-3 px-4 text-right"></th>
                    </tr>
                </thead>

                <tbody id="cartBody">
                    @foreach($order->items as $item)
                        <tr id="item-{{ $item->id }}" class="border-b hover:bg-slate-50">

                            <!-- IMAGE -->
                            <td class="py-3 px-4">
                                <img src="{{ asset('storage/'.$item->product->image) }}"
                                     class="h-12 w-12 rounded-lg object-cover border"
                                     onerror="this.src='/placeholder.png'">
                            </td>

                            <!-- NAME -->
                            <td class="py-3 px-4 font-medium">
                                {{ $item->product->name }}
                            </td>

                            <!-- PRICE -->
                            <td class="py-3 px-4">
                                {{ number_format($item->price, 2) }} LBP
                            </td>

                            <!-- QUANTITY -->
                            <td class="py-3 px-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <button onclick="updateQty({{ $item->id }}, -1)"
                                            class="px-2 py-1 bg-slate-200 rounded   {{ $isCompleted ? 'opacity-50 cursor-not-allowed' : '' }}"
        {{ $isCompleted ? 'disabled' : '' }}>-</button>

                                    <span id="qty-{{ $item->id }}">{{ $item->quantity }}</span>

                                    <button onclick="updateQty({{ $item->id }}, 1)"
                                            class="px-2 py-1 bg-slate-200 rounded   {{ $isCompleted ? 'opacity-50 cursor-not-allowed' : '' }}"
        {{ $isCompleted ? 'disabled' : '' }}>+</button>
                                </div>
                            </td>

                            <!-- SUBTOTAL -->
                            <td class="py-3 px-4 text-right font-semibold"
                                id="subtotal-{{ $item->id }}">
                                {{ number_format($item->quantity * $item->price, 2) }} LBP
                            </td>

                            <!-- DELETE -->
                            <td class="py-3 px-4 text-right">
                                <button onclick="deleteItem({{ $item->id }})"
                                        class="text-red-600 font-semibold   {{ $isCompleted ? 'opacity-50 cursor-not-allowed' : '' }}"
        {{ $isCompleted ? 'disabled' : '' }}>Remove</button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- TOTAL -->
        <div class="text-right text-xl font-bold mt-6">
            Total: <span id="orderTotal">{{ number_format($order->total, 2) }}</span> LBP
        </div>

        <!-- ADD PRODUCT -->
        <div class="mt-6 pt-4 border-t">
            <h3 class="text-lg font-bold mb-3">Add Product</h3>

            <div class="flex gap-3">
                <input type="text" id="productSearch" 
                class="border rounded-xl px-3 py-2 w-full"
                placeholder="Search product...">

            <div id="searchResults"
                class="border rounded-xl mt-10 bg-white hidden absolute w-full z-50"></div>

            <input type="hidden" id="productId">


                <input id="addQty" type="number" min="1" value="1"
                       class="w-20 border rounded-xl px-3 py-2">

                <button onclick="addItem({{ $order->id }})"
                        class="bg-emerald-600 text-white px-4 py-2 rounded-xl hover:bg-emerald-700   {{ $isCompleted ? 'opacity-50 cursor-not-allowed' : '' }}"
        {{ $isCompleted ? 'disabled' : '' }}>
                    Add
                </button>
            </div>
        </div>

    </div>

    <!-- CUSTOMER INFO -->
    <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
        <h2 class="text-xl font-bold mb-4">Customer Information</h2>

        <div class="grid md:grid-cols-2 gap-6">

            <div>
                <p class="text-slate-500 text-sm">Full Name</p>
                <p class="font-semibold">{{ $order->customer_name }}</p>
            </div>

            <!-- WHATSAPP LINK -->
            <div>
                <p class="text-slate-500 text-sm">Phone</p>

                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}"
                   target="_blank"
                   class="font-semibold text-emerald-600 underline hover:text-emerald-700">
                    {{ $order->customer_phone }}
                </a>
            </div>

            <div>
                <p class="text-slate-500 text-sm">Address</p>
                <p class="font-semibold">{{ $order->address }}</p>
            </div>

            <div>
                <p class="text-slate-500 text-sm">Area</p>
                <p class="font-semibold">{{ $order->area }}</p>
            </div>

            <div>
                <p class="text-slate-500 text-sm">Payment Method</p>
                <p class="font-semibold">{{ ucfirst($order->payment_method) }}</p>
            </div>

            <div>
                <p class="text-slate-500 text-sm">Date</p>
                <p class="font-semibold">{{ $order->created_at->format('Y-m-d H:i') }}</p>
            </div>

            @if($order->location)
                <div class="md:col-span-2">
                    <p class="text-slate-500 text-sm">Location</p>
                    <a href="https://maps.google.com/?q={{ $order->location }}"
                       target="_blank"
                       class="text-blue-600 underline">
                        View on Map
                    </a>
                </div>
            @endif

            @if($order->note)
                <div class="md:col-span-2">
                    <p class="text-slate-500 text-sm">Customer Note</p>
                    <p class="font-semibold">{{ $order->note }}</p>
                </div>
            @endif

        </div>
    </div>

</div>
@endsection


