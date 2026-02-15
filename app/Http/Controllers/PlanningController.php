<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlanningController extends Controller
{
    // --- BOM Management ---
    public function bom()
    {
        $products = \App\Models\Product::with('wbsNodes')->get();
        $materials = \App\Models\Material::all();
        $boms = \App\Models\BOM::with(['product', 'material'])->get();
        return view('planning.bom', compact('products', 'materials', 'boms'));
    }

    public function storeBom(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|numeric|min:0',
        ]);

        \App\Models\BOM::create($request->all());

        return redirect()->route('planning.bom.index')->with('success', 'BOM entry added successfully.');
    }

    public function destroyBom(\App\Models\BOM $bom)
    {
        $bom->delete();
        return redirect()->route('planning.bom.index')->with('success', 'BOM entry removed.');
    }

    // --- Material Management ---
    public function index()
    {
        $materials = \App\Models\Material::all();
        return view('planning.materials.index', compact('materials'));
    }

    public function create()
    {
        return view('planning.materials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:materials',
            'unit' => 'required',
            'cost_per_unit' => 'required|numeric',
        ]);

        \App\Models\Material::create($request->all());

        return redirect()->route('planning.materials.index')->with('success', 'Material added successfully.');
    }

    public function edit(\App\Models\Material $material)
    {
        return view('planning.materials.edit', compact('material'));
    }

    public function update(Request $request, \App\Models\Material $material)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:materials,code,' . $material->id,
            'unit' => 'required',
            'cost_per_unit' => 'required|numeric',
        ]);

        $material->update($request->all());

        return redirect()->route('planning.materials.index')->with('success', 'Material updated successfully.');
    }

    public function destroy(\App\Models\Material $material)
    {
        $material->delete();
        return redirect()->route('planning.materials.index')->with('success', 'Material deleted.');
    }

    public function schedule()
    {
        $products = \App\Models\Product::all();
        $schedules = \App\Models\ProductionSchedule::with('product')->orderBy('start_date')->get();
        return view('planning.schedule', compact('products', 'schedules'));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'activity_name' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        \App\Models\ProductionSchedule::create($request->all());

        return redirect()->route('planning.schedule.index')->with('success', 'Production schedule added.');
    }

    public function destroySchedule(\App\Models\ProductionSchedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('planning.schedule.index')->with('success', 'Schedule removed.');
    }
}
