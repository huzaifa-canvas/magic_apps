<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmploymentStatus;
use Illuminate\Http\Request;

class EmploymentStatusController extends Controller
{
    public function index()
    {
        $employmentStatuses = EmploymentStatus::latest()->paginate(20);
        return view('admin.employment_statuses.index', compact('employmentStatuses'));
    }

    public function create()
    {
        return view('admin.employment_statuses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        EmploymentStatus::create($request->only(['name', 'status']));

        return redirect()->route('admin.employment-statuses.index')->with('success', 'Employment status created successfully.');
    }

    public function edit(string $id)
    {
        $employmentStatus = EmploymentStatus::findOrFail($id);
        return view('admin.employment_statuses.edit', compact('employmentStatus'));
    }

    public function update(Request $request, string $id)
    {
        $employmentStatus = EmploymentStatus::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $employmentStatus->update($request->only(['name', 'status']));

        return redirect()->route('admin.employment-statuses.index')->with('success', 'Employment status updated successfully.');
    }

    public function destroy(string $id)
    {
        $employmentStatus = EmploymentStatus::findOrFail($id);
        $employmentStatus->delete();

        return redirect()->route('admin.employment-statuses.index')->with('success', 'Employment status deleted successfully.');
    }
}
