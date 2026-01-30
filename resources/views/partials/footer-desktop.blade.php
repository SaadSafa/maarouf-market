@php
    $adminWhatsapp = config('services.admin.whatsapp', '96176912663');
@endphp

{{-- Desktop Footer --}}
<footer class="hidden sm:block backdrop-blur border-t mt-12 footer-surface">
    <div class="max-w-6xl mx-auto px-4 py-10 grid grid-cols-1 sm:grid-cols-3 gap-8 text-sm text-slate-700">

        {{-- Column 1 - Logo + About --}}
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="inline-flex items-center justify-center rounded-xl bg-green-600 text-white w-8 h-8 text-lg font-bold">
                    MM
                </span>
                <span class="font-extrabold text-lg text-slate-900">
                    Maarouf <span class="text-green-600">Market</span>
                </span>
            </div>

            <p class="text-slate-600 text-sm leading-relaxed">
                Maarouf Market delivers fresh groceries, fruits, vegetables,
                and essential household products right to your door - fast,
                affordable and always high-quality.
            </p>
        </div>

        {{-- Column 2 - Quick Links --}}
        <div>
            <h3 class="font-semibold text-slate-900 mb-3">Quick Links</h3>
            <ul class="space-y-2">
                <li><a href="{{ route('home') }}" class="hover:text-green-600">Home</a></li>

                @auth
                    <li><a href="{{ route('orders.index') }}" class="hover:text-green-600">My Orders</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="hover:text-green-600">Profile</a></li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:text-green-600">Login</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-green-600">Register</a></li>
                @endauth

                <li><a href="https://wa.me/{{ $adminWhatsapp }}" target="_blank"
                       class="hover:text-green-600">Contact Us</a></li>
            </ul>
        </div>

        {{-- Column 3 - Contact --}}
        <div>
            <h3 class="font-semibold text-slate-900 mb-3">Contact</h3>

            <ul class="space-y-2 text-slate-600">
                <li>
                    <span class="font-medium">WhatsApp:</span>
                    <a href="https://wa.me/{{ $adminWhatsapp }}"
                       class="text-green-600 hover:underline"
                       target="_blank">+{{ $adminWhatsapp }}</a>
                </li>
                <li>
                    <span class="font-medium">Location:</span> Saida, Lebanon
                </li>
                <li>
                    <span class="font-medium">Working Hours:</span><br>
                    10:00 AM - 6:00 PM
                </li>
            </ul>
        </div>

    </div>

    <div class="border-t border-slate-200 py-3 text-center text-xs text-slate-500">
        (c) {{ date('Y') }} Maarouf Market - All rights reserved.
    </div>
</footer>
