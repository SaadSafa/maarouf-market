@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="max-w-lg mx-auto space-y-6">

    <div class="flex items-center gap-4">
        <a href="{{ route('admin.categories.index') }}" class="p-2 rounded-lg hover:bg-slate-100">
            <svg class="h-5 w-5" fill="none" stroke="currentColor">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                      d="M15 19l-7-7 7-7"/>
            </svg>
        </a>

        <div>
            <h1 class="text-2xl font-bold text-slate-900">Edit Category</h1>
        </div>
    </div>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST"
    enctype="multipart/form-data"
          class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="text-sm font-medium text-slate-700">Category Name</label>
            <input type="text" name="name" value="{{ $category->name }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300">
        </div>
         <label class="text-sm font-medium text-slate-700">Category Image</label>
        <div class="h-12 w-12 sm:h-12 sm:w-12 rounded-lg sm:rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-50 flex items-center justify-center text-emerald-700 text-xl sm:text-xl font-bold flex-shrink-0 shadow-sm">
                                <img src="{{asset('storage/' . $category->image) }}">
                            </div>
                            <div>
                                 <label class="text-sm font-medium text-slate-700">want to change image?</label>
            <input type="file" name="image" 
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300">
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white">
                Update
            </button>
        </div>

    </form>

</div>
@endsection
