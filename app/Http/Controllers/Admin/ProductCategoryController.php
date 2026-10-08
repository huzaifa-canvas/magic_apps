<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategories::latest()->paginate(20);
        return view('admin.product_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'status' => (bool) $request->status,
        ];

        if ($request->hasFile('image')) {
            $f = $request->file('image');
            $n = time() . '_' . $f->getClientOriginalName();
            $f->move(public_path('uploads/product-categories'), $n);
            $data['image'] = 'uploads/product-categories/' . $n;
        }

        ProductCategories::create($data);

        return redirect()->route('admin.product-categories.index')->with('success', 'Product category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = ProductCategories::findOrFail($id);
        return view('admin.product_categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = ProductCategories::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'status' => (bool) $request->status,
        ];

        if ($request->hasFile('image')) {
            if ($category->image && !Str::startsWith($category->image, 'http')) {
                $old = public_path($category->image);
                if (File::exists($old)) {
                    File::delete($old);
                }
            }

            $f = $request->file('image');
            $n = time() . '_' . $f->getClientOriginalName();
            $f->move(public_path('uploads/product-categories'), $n);
            $data['image'] = 'uploads/product-categories/' . $n;
        }

        $category->update($data);

        return redirect()->route('admin.product-categories.index')->with('success', 'Product category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = ProductCategories::findOrFail($id);

        if ($category->image && !Str::startsWith($category->image, 'http')) {
            $old = public_path($category->image);
            if (File::exists($old)) {
                File::delete($old);
            }
        }

        $category->delete();

        return redirect()->route('admin.product-categories.index')->with('success', 'Product category deleted successfully.');
    }
}
