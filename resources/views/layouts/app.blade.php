<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col bg-gray-100">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="bg-gray-900 text-gray-300 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                    <!-- Top Section -->
                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-10">
            
                        <!-- Logo & About -->
                        <div class="text-center lg:text-left">
                            <div class="flex items-center justify-center lg:justify-start gap-2">
                                <x-application-logo class="w-8 h-8 text-white" />
                                <h2 class="text-2xl font-bold text-white">Luna</h2>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-gray-400">
                                Lapak UMKM Indonesia
                            </p>
                        </div>
            
                        <!-- Quick Links -->
                        <div class="text-center lg:text-left">
                            <h3 class="text-lg font-semibold text-white mb-3">Link Cepat</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('beranda') }}" class="hover:text-white transition">Beranda</a></li>
                                @if (Auth::user())
                                    <li><a href="{{ route('koneksi') }}" class="hover:text-white transition">Koneksi</a></li>
                                @endif
                                <li><a href="{{ route('edukasi') }}" class="hover:text-white transition">Edukasi</a></li>
                                @if (Auth::user())
                                    <li><a href="{{ route('profile') }}" class="hover:text-white transition">Profil</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
            
                    <!-- Bottom -->
                    <div class="mt-10 border-t border-gray-700 pt-6">
                        <p class="text-center text-sm text-gray-400">
                            © {{ date('Y') }} Luna. All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>


        </div>
    </body>
</html>
