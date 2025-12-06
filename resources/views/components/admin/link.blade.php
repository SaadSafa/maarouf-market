@props(['route', 'title'])

@php
    $active = request()->routeIs($route) ? true : false;
@endphp

<a href="{{ route($route) }}"
   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all
          {{ $active 
                ? 'bg-emerald-600 text-white shadow-md' 
                : 'text-slate-700 hover:bg-emerald-50 hover:text-emerald-700' }}">
    <span class="w-2 h-2 rounded-full {{ $active ? 'bg-white' : 'bg-emerald-400' }}"></span>
    {{ $title }}
</a>
