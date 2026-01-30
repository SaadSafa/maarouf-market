<x-app-layout>
    <div class="py-8 sm:py-12">
        <div class="space-y-8">

            {{-- Hero --}}
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-green-600 via-emerald-500 to-lime-400 text-white shadow-lg">
                <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.4) 0, transparent 35%), radial-gradient(circle at 80% 0%, rgba(255,255,255,0.25) 0, transparent 40%);"></div>
                <div class="relative px-6 sm:px-8 py-8 sm:py-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] font-semibold text-white/80">Account Center</p>
                        <h1 class="mt-2 text-2xl sm:text-3xl font-extrabold">Welcome back, {{ $user->name }}.</h1>
                        <p class="mt-2 text-white/90 text-sm sm:text-base">Manage your details, security, and preferences in one place.</p>
                        <div class="mt-4 flex flex-wrap gap-3 text-xs sm:text-sm text-white/90">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 border border-white/20">
                                <span class="w-2 h-2 rounded-full bg-lime-200"></span>
                                Signed in as {{ $user->email }}
                            </span>
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/15">
                                Member since {{ optional($user->created_at)->format('M Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="shrink-0">
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-white/15 border border-white/25 backdrop-blur flex items-center justify-center text-3xl sm:text-4xl font-black">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="p-5 sm:p-6 bg-white rounded-2xl shadow-sm border border-slate-100 profile-panel">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="p-5 sm:p-6 bg-white rounded-2xl shadow-sm border border-slate-100 profile-panel">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="p-5 sm:p-6 bg-white rounded-2xl shadow-sm border border-slate-100 profile-panel">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
