<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductionSystemController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:products',
            'system_type' => 'required',
        ]);

        \App\Models\Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(\App\Models\Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(\App\Models\Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, \App\Models\Product $product)
    {
         $request->validate([
            'name' => 'required',
            'code' => 'required|unique:products,code,' . $product->id,
            'system_type' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(\App\Models\Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function storeWbsNode(Request $request, \App\Models\Product $product)
    {
        $request->validate([
            'name' => 'required',
            'cost_estimate' => 'nullable|numeric'
        ]);

        $product->wbsNodes()->create($request->all());

        return redirect()->route('products.show', $product)->with('success', 'WBS Node added successfully.');
    }

    public function destroyWbsNode(\App\Models\WBSNode $wbsNode)
    {
        $product = $wbsNode->product;
        $wbsNode->delete();
        return redirect()->route('products.show', $product)->with('success', 'WBS Node deleted successfully.');
    }
}
