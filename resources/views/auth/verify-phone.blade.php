@extends('layouts.app')

@section('content')


<form method="POST" action="{{ route('phone.verify') }}" class="max-w-md mx-auto p-8 bg-white bg-opacity-90 backdrop-blur-lg rounded-xl shadow-lg border border-green-100">
    @csrf

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-green-800">Verify Your Phone</h2>
        <p class="text-sm text-green-600 mt-1">Enter the code sent to your mobile</p>
    </div>

    <div class="mb-6">
        <label for="otp" class="block text-sm font-medium text-green-700 mb-2">Verification Code</label>
        <input type="text" 
               name="otp" 
               id="otp" 
               inputmode="numeric" 
               autocomplete="one-time-code" 
               required
               class="w-full px-5 py-4 border-2 border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 text-center text-xl font-semibold tracking-wider text-green-800">
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 border-2 border-red-200 rounded-lg">
            <ul class="text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <button type="submit" 
            class="w-full py-4 px-6 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-400">
        Verify & Continue
    </button>
</form>
@endsection