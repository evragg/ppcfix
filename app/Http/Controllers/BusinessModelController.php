<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessModelController extends Controller
{
    public function index()
    {
        $stakeholders = \App\Models\Stakeholder::all();
        return view('stakeholders.index', compact('stakeholders'));
    }

    public function create()
    {
        return view('stakeholders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'matrix_position' => 'nullable',
        ]);

        \App\Models\Stakeholder::create($request->all());

        return redirect()->route('stakeholders.index')->with('success', 'Stakeholder added successfully.');
    }

    public function edit(\App\Models\Stakeholder $stakeholder)
    {
        return view('stakeholders.edit', compact('stakeholder'));
    }

    public function update(Request $request, \App\Models\Stakeholder $stakeholder)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
        ]);

        $stakeholder->update($request->all());

        return redirect()->route('stakeholders.index')->with('success', 'Stakeholder updated successfully.');
    }

    public function destroy(\App\Models\Stakeholder $stakeholder)
    {
        $stakeholder->delete();
        return redirect()->route('stakeholders.index')->with('success', 'Stakeholder removed.');
    }
}
