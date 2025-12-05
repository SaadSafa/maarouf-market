@extends('admin.layouts.app')

@section('title', 'Sliders')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Sliders</h1>
            <p class="text-slate-500 mt-1">Manage homepage promotional banners</p>
        </div>

        <a href="{{ route('admin.sliders.create') }}"
           class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 transition text-white px-5 py-2.5 rounded-xl shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            <span class="font-medium">Add Slider</span>
        </a>
    </div>

    <!-- Sliders Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        @foreach($sliders as $slider)
            <div class="group bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden
                        hover:shadow-md transition duration-200">

                <!-- Image -->
                <div class="relative aspect-video">
                    <img src="{{ asset('storage/' . $slider->image) }}"
                         alt="{{ $slider->title }}"
                         class="w-full h-full object-cover">

                    <!-- Status Badge -->
                    @php
    $statusClass = $slider->is_active == 1
        ? 'bg-emerald-600 text-white'
        : 'bg-slate-300 text-slate-700';
@endphp

<span class="absolute top-3 right-3 px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusClass }}">
    {{ ucfirst($slider->status) }}
</span>

                </div>

                <!-- Content -->
                <div class="p-5 space-y-4">

                    <!-- Title -->
                    <h3 class="text-lg font-semibold text-slate-900">{{ $slider->title }}</h3>

                    <!-- Actions -->
                    <div class="flex justify-end items-center gap-4 text-sm">

                        <!-- Edit -->
                        <a href="{{ route('admin.sliders.edit', ['offerSlider' => $slider]) }}"
                           class="flex items-center gap-1 text-emerald-600 font-medium hover:text-emerald-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.232 5.232l3.536 3.536M4 20h4l10-10-4-4L4 16v4z" />
                            </svg>
                            Edit
                        </a>

                        <!-- Delete -->
                        <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST"
                              onsubmit="return confirm('Delete slider?')" class="flex items-center gap-1">
                            @csrf @method('DELETE')

                            <button class="flex items-center gap-1 text-red-600 font-medium hover:text-red-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Delete
                            </button>
                        </form>

                    </div>

                </div>
            </div>
        @endforeach

    </div>

</div>
@endsection
