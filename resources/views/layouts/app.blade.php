<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>{{ config('app.name', 'Assignment') }}</title>

    <!-- Fonts -->
    <link
        rel="preconnect"
        href="https://fonts.bunny.net"
    >
    <link
        href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600"
        rel="stylesheet"
    />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main class="bg-blue-50 h-screen p-3">
        @auth
            <header class="card flex justify-between items-center shadow-sm mb-3 p-3">
                <x-logo/>
                <div class="flex gap-x-6 items-center">
                    <div class="flex gap-x-1.5 items-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="30"
                            height="30"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="bg-blue-300 rounded-full p-1.5 text-blue-600"
                        >
                            <circle
                                cx="12"
                                cy="8"
                                r="5"
                            />
                            <path d="M20 21a8 8 0 0 0-16 0"/>
                        </svg>
                        <span>{{ auth()->user()->name }}</span>
                    </div>
                    <form
                        method="POST"
                        action="/logout"
                    >
                        @csrf
                        <button
                            type="submit"
                            class="border-2 border-blue-600 px-3 py-1.5 text-blue-600"
                        >
                            Log out
                        </button>
                    </form>
                </div>
            </header>
        @endauth
        @yield('content')
    </main>
</body>
</html>
