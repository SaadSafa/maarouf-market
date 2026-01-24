@php
    // Admin WhatsApp for contact (change number as needed)
    $adminWhatsapp = config('services.admin.whatsapp', '96170000000');
@endphp

{{-- Mobile Bottom Navigation --}}
<footer class="fixed bottom-0 inset-x-0 z-40 bg-white/90 backdrop-blur border-t border-emerald-100 sm:hidden pointer-events-auto">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between py-2 text-xs text-slate-700">

            {{-- Home --}}
            <a href="{{ route('home') }}" class="flex-1 flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m3 12 9-9 9 9" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5V21h6v-5.25A1.5 1.5 0 0 1 12 14.25h0A1.5 1.5 0 0 1 13.5 15.75V21h6V10.5" />
                </svg>
                <span>Home</span>
            </a>

            {{-- Orders (only if logged in) --}}
            @auth
                <a href="{{ route('orders.index') }}" class="flex-1 flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5V6m7.5-1.5V6m-12 3h16.5M3.75 8.25v11.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V8.25M6.75 12h10.5m-10.5 4.5h6.75" />
                    </svg>
                    <span>Orders</span>
                </a>
            @endauth

            {{-- Contact via WhatsApp --}}
            <a href="https://wa.me/{{ $adminWhatsapp }}" target="_blank" rel="noopener noreferrer"
               class="flex-1 flex flex-col items-center font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 6.75 3.5-.583A2.25 2.25 0 0 1 8.4 7.063l1.005 2.09a2.25 2.25 0 0 1-.52 2.573l-.834.834a11.8 11.8 0 0 0 5.939 5.939l.834-.834a2.25 2.25 0 0 1 2.573-.52l2.09 1.005a2.25 2.25 0 0 1 1.896 2.65l-.583 3.5a2.25 2.25 0 0 1-2.234 1.875c-10.356 0-18.75-8.394-18.75-18.75A2.25 2.25 0 0 1 2.25 6.75z" />
                </svg>
                <span>Contact</span>
            </a>
        </div>
    </div>
</footer>
