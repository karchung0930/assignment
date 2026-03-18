@extends('layouts.app')

@section('content')
    <div class="flex h-full">
        <div class="flex flex-col w-1/2 gap-y-12 relative justify-center px-6">
            <x-logo/>
            <h1 class="text-6xl">
                <span>Seamless access to</span>
                <br>
                <b>care and benefits</b>
            </h1>
            <form
                method="POST"
                action="/login"
                class="w-2/3 relative"
                autocomplete="off"
            >
                @csrf
                <label>
                    Email
                    <input
                        id="input-email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                    >
                </label>
                <div>
                    <label for="password">
                        Password
                        <input
                            id="input-password"
                            type="password"
                            name="password"
                        >
                    </label>
                </div>
                <button class="btn-cta mt-3">Login</button>
                @error('login')
                <p
                    id="error-message"
                    class="absolute -bottom-9 left-0 text-red-600"
                >
                    {{ $message }}
                </p>
                @enderror
            </form>
        </div>
        <img
            src="{{ asset('images/doctor.png') }}"
            alt="A female doctor is pointing to the form."
            class="w-1/2 rounded-xl object-cover object-[36%] bg-blue-300"
        >
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputEmail = document.querySelector('#input-email');
        const inputPassword = document.querySelector('#input-password');
        const errorMessage = document.querySelector('#error-message');

        if (!errorMessage) {
            return;
        }

        if (inputEmail) {
            inputEmail.addEventListener('focus', function () {
                errorMessage.remove();
            });
        }

        if (inputPassword) {
            inputPassword.addEventListener('focus', function () {
                errorMessage.remove();
            });
        }
    });
</script>