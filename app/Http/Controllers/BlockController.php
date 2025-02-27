<?php

namespace App\Http\Controllers;

use App\Models\Blocks;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function index()
    {
        $blocks = Blocks::all();
        return view('admin.blocks.index', compact('blocks'));
    }

    public function create()
    {
        return view('admin.blocks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'block_name' => 'required|string|max:50',
        ]);

        Blocks::create($request->only(['block_name']));

        return redirect()->back()->with('success', 'Block added successfully.');
    }

    public function edit($id)
    {
        $block = Blocks::findOrFail($id);
        return view('admin.blocks.edit', compact('block'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'block_name' => 'required|string|max:50',
        ]);

        $block = Blocks::findOrFail($id);
        $block->update($request->only(['block_name']));

        return redirect()->back()->with('success', 'Block updated successfully.');
    }

    public function destroy($id)
    {
        $block = Blocks::findOrFail($id);
        $block->delete();

        return redirect()->back()->with('delete', 'Block deleted successfully.');
    }
}
