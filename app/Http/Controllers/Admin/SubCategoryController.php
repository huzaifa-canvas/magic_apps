<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::latest()->paginate(20);
        $categories = Category::all()->keyBy('id');
        return view('admin.sub_categories.index', compact('subCategories', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.sub_categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|boolean',
        ]);

        // The SubCategory model has a typo in $fillable ('categorie_id'),
        // so the FK is set explicitly rather than via mass assignment.
        $sub = new SubCategory();
        $sub->name = $request->name;
        $sub->slug = Str::slug($request->name);
        $sub->status = $request->status;
        $sub->category_id = $request->category_id;
        $sub->save();

        return redirect()->route('admin.sub-categories.index')->with('success', 'Sub-category created successfully.');
    }

    public function edit(string $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $categories = Category::where('status', 1)->get();
        return view('admin.sub_categories.edit', compact('subCategory', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $subCategory = SubCategory::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|boolean',
        ]);

        // The SubCategory model has a typo in $fillable ('categorie_id'),
        // so the FK is set explicitly rather than via mass assignment.
        $subCategory->name = $request->name;
        $subCategory->slug = Str::slug($request->name);
        $subCategory->status = $request->status;
        $subCategory->category_id = $request->category_id;
        $subCategory->save();

        return redirect()->route('admin.sub-categories.index')->with('success', 'Sub-category updated successfully.');
    }

    public function destroy(string $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->delete();

        return redirect()->route('admin.sub-categories.index')->with('success', 'Sub-category deleted successfully.');
    }
}
