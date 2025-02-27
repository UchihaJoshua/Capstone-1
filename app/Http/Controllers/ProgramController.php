<?php

namespace App\Http\Controllers;

use App\Models\Programs;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Programs::all();
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_name' => 'required|string|max:255',
            'program_acronym' => 'nullable|string|max:10',
        ]);

        Programs::create($request->only(['program_name', 'program_acronym']));

        return redirect()->back()->with('success', 'Program added successfully.');
    }

    public function edit($id)
    {
        $program = Programs::findOrFail($id);
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'program_name' => 'required|string|max:255',
            'program_acronym' => 'nullable|string|max:10',
        ]);

        $program = Programs::findOrFail($id);
        $program->update($request->only(['program_name', 'program_acronym']));

        return redirect()->back()->with('success', 'Program updated successfully.');
    }

    public function destroy($id)
    {
        $program = Programs::findOrFail($id);
        $program->delete();

        return redirect()->back()->with('delete', 'Program deleted successfully.');
    }
}
