<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfferSlider;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSliderController extends Controller
{
    public function __construct()
{
    $this->middleware('admin');
}

    public function index()
    {
        $sliders = OfferSlider::latest()->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|max:255',
            'subtitle'  => 'nullable|max:255',
            'image'     => 'required|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        OfferSlider::create($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider created.');
    }

    public function edit(OfferSlider $offerSlider)
{
    return view('admin.sliders.edit', ['slider' => $offerSlider]);
}


    public function update(Request $request, OfferSlider $slider)
    {
        $validated = $request->validate([
            'title'     => 'required|max:255',
            'subtitle'  => 'nullable|max:255',
            'image'     => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider updated.');
    }

    public function destroy(OfferSlider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider deleted.');
    }
}
