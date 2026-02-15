<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductionControlController extends Controller
{
    public function index()
    {
        $orders = \App\Models\ProductionOrder::orderBy('created_at', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_number' => 'required|unique:production_orders',
            'type' => 'required|in:material,work',
            'details' => 'nullable',
        ]);

        \App\Models\ProductionOrder::create($request->all());

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(\App\Models\ProductionOrder $order)
    {
        return view('orders.show', compact('order'));
    }

    public function edit(\App\Models\ProductionOrder $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, \App\Models\ProductionOrder $order)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $order->update($request->only('status', 'details'));

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(\App\Models\ProductionOrder $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted.');
    }
}
