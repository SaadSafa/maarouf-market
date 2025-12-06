@extends('admin.layouts.app')

@section('title', 'Create Category')

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
            <h1 class="text-2xl font-bold text-slate-900">Add Category</h1>
            <p class="text-slate-500">Create a new product category</p>
        </div>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST"
          class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf

        <div>
            <label class="text-sm font-medium text-slate-700">Category Name</label>
            <input type="text" name="name" required
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300">
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white">
                Create
            </button>
        </div>

    </form>

</div>
@endsection
