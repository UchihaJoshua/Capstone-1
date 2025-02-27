<?php

namespace App\Http\Controllers;

use App\Models\Years;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function index()
    {
        $years = Years::all();
        return view('admin.years.index', compact('years'));
    }

    public function create()
    {
        return view('admin.years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year_level' => 'required|string|max:50',
        ]);

        Years::create($request->only(['year_level']));

        return redirect()->back()->with('success', 'Year added successfully.');
    }

    public function edit($id)
    {
        $year = Years::findOrFail($id);
        return view('admin.years.edit', compact('year'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'year_level' => 'required|string|max:50',
        ]);

        $year = Years::findOrFail($id);
        $year->update($request->only(['year_level']));

        return redirect()->back()->with('success', 'Year updated successfully.');
    }

    public function destroy($id)
    {
        $year = Years::findOrFail($id);
        $year->delete();

        return redirect()->back()->with('delete', 'Year deleted successfully.');
    }
}
