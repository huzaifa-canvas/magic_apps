<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkillTypes;
use Illuminate\Http\Request;

class SkillTypeController extends Controller
{
    public function index()
    {
        $skillTypes = SkillTypes::latest()->paginate(20);
        return view('admin.skill_types.index', compact('skillTypes'));
    }

    public function create()
    {
        return view('admin.skill_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status'      => 'required|boolean',
        ]);

        $data = $request->only(['name', 'description', 'status']);

        if ($request->hasFile('icon')) {
            $f = $request->file('icon');
            $n = time() . '_' . $f->getClientOriginalName();
            $f->move(public_path('uploads/skill-types'), $n);
            $data['icon'] = 'uploads/skill-types/' . $n;
        }

        SkillTypes::create($data);

        return redirect()->route('admin.skill-types.index')->with('success', 'Skill type created successfully.');
    }

    public function edit(string $id)
    {
        $skillType = SkillTypes::findOrFail($id);
        return view('admin.skill_types.edit', compact('skillType'));
    }

    public function update(Request $request, string $id)
    {
        $skillType = SkillTypes::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status'      => 'required|boolean',
        ]);

        $data = $request->only(['name', 'description', 'status']);

        if ($request->hasFile('icon')) {
            $f = $request->file('icon');
            $n = time() . '_' . $f->getClientOriginalName();
            $f->move(public_path('uploads/skill-types'), $n);
            $data['icon'] = 'uploads/skill-types/' . $n;
        }

        $skillType->update($data);

        return redirect()->route('admin.skill-types.index')->with('success', 'Skill type updated successfully.');
    }

    public function destroy(string $id)
    {
        $skillType = SkillTypes::findOrFail($id);
        $skillType->delete();

        return redirect()->route('admin.skill-types.index')->with('success', 'Skill type deleted successfully.');
    }
}
