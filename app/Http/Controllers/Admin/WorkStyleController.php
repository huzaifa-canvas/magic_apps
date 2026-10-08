<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkStyle;
use Illuminate\Http\Request;

class WorkStyleController extends Controller
{
    public function index()
    {
        $workStyles = WorkStyle::latest()->paginate(20);
        return view('admin.work_styles.index', compact('workStyles'));
    }

    public function create()
    {
        return view('admin.work_styles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        WorkStyle::create($request->only(['name', 'status']));

        return redirect()->route('admin.work-styles.index')->with('success', 'Work style created successfully.');
    }

    public function edit(string $id)
    {
        $workStyle = WorkStyle::findOrFail($id);
        return view('admin.work_styles.edit', compact('workStyle'));
    }

    public function update(Request $request, string $id)
    {
        $workStyle = WorkStyle::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $workStyle->update($request->only(['name', 'status']));

        return redirect()->route('admin.work-styles.index')->with('success', 'Work style updated successfully.');
    }

    public function destroy(string $id)
    {
        $workStyle = WorkStyle::findOrFail($id);
        $workStyle->delete();

        return redirect()->route('admin.work-styles.index')->with('success', 'Work style deleted successfully.');
    }
}
