<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Qualification;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    public function index()
    {
        $qualifications = Qualification::latest()->paginate(20);
        return view('admin.qualifications.index', compact('qualifications'));
    }

    public function create()
    {
        return view('admin.qualifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        Qualification::create($request->only(['name', 'status']));

        return redirect()->route('admin.qualifications.index')->with('success', 'Qualification created successfully.');
    }

    public function edit(string $id)
    {
        $qualification = Qualification::findOrFail($id);
        return view('admin.qualifications.edit', compact('qualification'));
    }

    public function update(Request $request, string $id)
    {
        $qualification = Qualification::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $qualification->update($request->only(['name', 'status']));

        return redirect()->route('admin.qualifications.index')->with('success', 'Qualification updated successfully.');
    }

    public function destroy(string $id)
    {
        $qualification = Qualification::findOrFail($id);
        $qualification->delete();

        return redirect()->route('admin.qualifications.index')->with('success', 'Qualification deleted successfully.');
    }
}
