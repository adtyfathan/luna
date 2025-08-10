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
        <div class="min-h-screen bg-gray-100">
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
            <main>
                {{ $slot }}
                <footer class="bg-gray-900 text-gray-300 py-10 mt-10">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                
                            <!-- Logo & About -->
                            <div>
                                <div class="flex items-center gap-2">
                                    <x-application-logo />
                                    <h2 class="text-2xl font-bold text-white">Luna</h2>
                                </div>
                                
                                <p class="mt-3 text-sm leading-6">
                                    Lapak UMKM Indonesia
                                </p>
                            </div>
                
                            <!-- Quick Links -->
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-3">Quick Links</h3>
                                <ul class="space-y-2">
                                    <li><a href="" class="hover:text-white transition">Home</a></li>
                                    <li><a href="" class="hover:text-white transition">About</a></li>
                                    <li><a href="" class="hover:text-white transition">Services</a></li>
                                    <li><a href="" class="hover:text-white transition">Contact</a></li>
                                </ul>
                            </div>
                
                            <!-- Resources -->
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-3">Resources</h3>
                                <ul class="space-y-2">
                                    <li><a href="" class="hover:text-white transition">Blog</a></li>
                                    <li><a href="" class="hover:text-white transition">Help Center</a></li>
                                    <li><a href="" class="hover:text-white transition">Terms of Service</a></li>
                                    <li><a href="" class="hover:text-white transition">Privacy Policy</a></li>
                                </ul>
                            </div>
                        </div>
                
                        <!-- Bottom -->
                        <div class="mt-10 border-t border-gray-700 pt-6 text-center text-sm">
                            © {{ date('Y') }} Luna. All rights reserved.
                        </div>
                    </div>
                </footer>

            </main>
        </div>
    </body>
</html>
