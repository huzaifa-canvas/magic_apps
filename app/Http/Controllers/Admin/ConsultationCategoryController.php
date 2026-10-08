<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConsultationCategoryController extends Controller
{
    public function index()
    {
        $consultationCategories = ConsultationCategories::latest()->paginate(20);
        return view('admin.consultation_categories.index', compact('consultationCategories'));
    }

    public function create()
    {
        return view('admin.consultation_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active'   => 'required|boolean',
        ]);

        $data = $request->only(['name', 'description', 'is_active']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('icon')) {
            $f = $request->file('icon');
            $n = time() . '_' . $f->getClientOriginalName();
            $f->move(public_path('uploads/consultation-categories'), $n);
            $data['icon'] = 'uploads/consultation-categories/' . $n;
        }

        ConsultationCategories::create($data);

        return redirect()->route('admin.consultation-categories.index')->with('success', 'Consultation category created successfully.');
    }

    public function edit(string $id)
    {
        $consultationCategory = ConsultationCategories::findOrFail($id);
        return view('admin.consultation_categories.edit', compact('consultationCategory'));
    }

    public function update(Request $request, string $id)
    {
        $consultationCategory = ConsultationCategories::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active'   => 'required|boolean',
        ]);

        $data = $request->only(['name', 'description', 'is_active']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('icon')) {
            $f = $request->file('icon');
            $n = time() . '_' . $f->getClientOriginalName();
            $f->move(public_path('uploads/consultation-categories'), $n);
            $data['icon'] = 'uploads/consultation-categories/' . $n;
        }

        $consultationCategory->update($data);

        return redirect()->route('admin.consultation-categories.index')->with('success', 'Consultation category updated successfully.');
    }

    public function destroy(string $id)
    {
        $consultationCategory = ConsultationCategories::findOrFail($id);
        $consultationCategory->delete();

        return redirect()->route('admin.consultation-categories.index')->with('success', 'Consultation category deleted successfully.');
    }
}
