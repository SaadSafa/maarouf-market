@extends('admin.layouts.app')

@section('title', 'Edit Slider')

@section('content')
<div class="max-w-lg mx-auto space-y-6">

    <div class="flex items-center gap-4">
        <a href="{{ route('admin.sliders.index') }}" class="p-2 rounded-lg hover:bg-slate-100">
            <svg class="h-5 w-5" fill="none" stroke="currentColor">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      d="M15 19l-7-7 7-7"/>
            </svg>
        </a>

        <div>
            <h1 class="text-2xl font-bold text-slate-900">Edit Slider</h1>
        </div>
    </div>

    <form action="{{ route('admin.sliders.update', $slider) }}" 
          method="POST" enctype="multipart/form-data"
          class="bg-white p-6 rounded-2xl shadow-sm border space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="text-sm font-medium text-slate-700">Title</label>
            <input type="text" name="title" value="{{ $slider->title }}"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300">
        </div>

        <div>
            <label class="text-sm font-medium text-slate-700">Description</label>
            <input type="text" name="description" value="{{ $slider->description }}"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300">
        </div>

        <div>
            <label class="text-sm font-medium text-slate-700">Current Image</label>
            <img src="{{ asset('storage/' . $slider->image) }}" class="w-full rounded-lg mb-3">
            <input type="file" name="image" class="w-full text-sm">
        </div>

        <div>
            <label class="text-sm font-medium text-slate-700">Status</label>
            <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-300">
    <option value="1" @selected(intval($slider->is_active) === 1)>Active</option>
    <option value="0" @selected(intval($slider->is_active) === 0)>Inactive</option>
</select>
        </div>
        


        <div class="flex justify-end">
            <button class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white">Update</button>
        </div>

    </form>

</div>
@endsection
