@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-2xl font-bold mb-6 text-center">Forgot Password</h2>
            <p class="text-gray-600 text-sm mb-4">
                Enter your email address and we'll send you a password reset link.
            </p>
            
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        value="{{ old('email') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                        required 
                        autofocus
                    >
                </div>

                <div class="flex items-center justify-between">
                    <button 
                        type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                    >
                        Send Reset Link
                    </button>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-800 font-bold text-sm">
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
