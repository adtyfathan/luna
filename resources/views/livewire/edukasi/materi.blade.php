<div class="min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('edukasi') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Section - Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $materi->judul }}</h1>

                    <!-- Class Image -->
                    <div class="relative w-full mb-6 rounded-lg overflow-hidden">
                        @if ($materi->avatar)
                            <img src="{{ Storage::url($materi->avatar) }}" alt="{{ $materi->judul }}" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/default-material.png') }}" alt="{{ $materi->judul }}" class="w-full h-full object-cover">
                        @endif
                        
                    </div>

                    <!-- Class Content -->
                    <div class="prose max-w-none mb-8">
                        {!! $materi->konten !!}
                    </div>
                </div>
            </div>

            <!-- Right Section - Recommendations -->
            <div class="space-y-6">
                <!-- Recommended Classes -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4">Rekomendasi Materi</h3>
                    <div class="space-y-3">
                        @foreach($recomends as $recomend)
                            <a href="{{ route('materi', $recomend->id) }}" class="flex gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="w-20 h-16 flex-shrink-0 rounded overflow-hidden">
                                    @if ($recomend->avatar)
                                        <img src="{{ Storage::url($recomend->avatar) }}" alt="{{ $recomend->judul }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="{{ asset('images/default-material.png') }}" alt="{{ $recomend->judul }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-sm text-gray-900 leading-tight">{{ $recomend->judul }}</h4>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>