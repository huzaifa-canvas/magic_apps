<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::latest()->paginate(20);
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'nullable|string|max:3',
            'status' => 'required|boolean',
        ]);

        Country::create($request->only(['name', 'code', 'status']));

        return redirect()->route('admin.countries.index')->with('success', 'Country created successfully.');
    }

    public function edit(string $id)
    {
        $country = Country::findOrFail($id);
        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, string $id)
    {
        $country = Country::findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'nullable|string|max:3',
            'status' => 'required|boolean',
        ]);

        $country->update($request->only(['name', 'code', 'status']));

        return redirect()->route('admin.countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy(string $id)
    {
        $country = Country::findOrFail($id);
        $country->delete();

        return redirect()->route('admin.countries.index')->with('success', 'Country deleted successfully.');
    }
}
