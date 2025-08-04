<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Ruang Edukasi UMKM</h1>
    
    <!-- Filter Tabs -->
    <div class="mb-8">
        <nav class="flex space-x-8">
            <!-- <button 
                class="pb-2 text-lg font-medium transition-colors">
                Semua
            </button>
            <button 
                class="pb-2 text-lg font-medium transition-colors">
                Finansial
            </button>
            <button 
                class="pb-2 text-lg font-medium transition-colors">
                Pemasaran
            </button> -->
            <div class="flex-1"></div>
            <input type="text" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors" placeholder="Cari materi...">
        </nav>
    </div>

    <!-- Course Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($edukasis as $edukasi)
        <a href="{{ route('materi', $edukasi->id) }}" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 cursor-pointer">
            <!-- Course Image with Tech Icons Overlay -->
            <div class="relative h-48 bg-gradient-to-br from-gray-800 via-gray-900 to-black">
                @if ($edukasi->avatar)
                    <img src="{{ Storage::url($edukasi->avatar) }}" alt="{{ $edukasi->judul }}" class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('images/default-material.png') }}" alt="{{ $edukasi->judul }}" class="w-full h-full object-cover">
                @endif
            </div>
            
            <!-- Course Content -->
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 leading-6">
                    {{ $edukasi->judul }}
                </h3>
            </div>
        </a>
    @endforeach
    </div>
    
    <!-- Empty State -->
    @if (empty($edukasis))
        <div class="text-center py-12">
            <div class="mx-auto h-12 w-12 text-gray-400 mb-4">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada materi tersedia</h3>
            <p class="text-gray-500">Belum ada materi untuk kategori yang dipilih.</p>
        </div>
    @endif
</div>