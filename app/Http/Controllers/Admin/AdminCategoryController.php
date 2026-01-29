<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
// use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Http\Request;
use Laravel\Pail\ValueObjects\Origin\Console;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function __construct()
{
    $this->middleware('admin');
}

    public function index()
    {
        $categories = Category::withCount('products')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $imageRule = 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048|dimensions:max_width=2000,max_height=2000';

        $validated = $request->validate(['name' => 'required|max:255','image' => $imageRule]);
          if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->storeAs(
                'products',
                Str::uuid()->toString() . '.' . $request->file('image')->getClientOriginalExtension(),
                'public'
            );
        }
        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
{
    $imageRule = 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048|dimensions:max_width=2000,max_height=2000';

    $validated = $request->validate([
        'name' => 'required|max:255',
        'image' => $imageRule
    ]);

    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        
        $validated['image'] = $request->file('image')->storeAs(
            'products',
            Str::uuid()->toString() . '.' . $request->file('image')->getClientOriginalExtension(),
            'public'
        );
    } else {
        // Remove image key if not uploaded to prevent overwriting with null
        unset($validated['image']);
    }

    $category->update($validated);

    return redirect()->route('admin.categories.index')
        ->with('success', 'Category updated.');
}


    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->withErrors('Cannot delete category with products.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted.');
    }
}
