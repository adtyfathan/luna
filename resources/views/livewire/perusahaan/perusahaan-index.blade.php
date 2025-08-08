<div class="max-w-4xl mt-5 mx-auto p-6 bg-white">
    @if($perusahaan)
        <!-- Header Section -->
        <div class="flex items-start justify-between mb-8">
            <div class="flex items-start space-x-6">
                <!-- Company Photo -->
                <div class="flex-shrink-0">
                    @if($perusahaan->logo)
                        <img src="{{ Storage::url($perusahaan->logo) }}" alt="{{ $perusahaan->nama_perusahaan }}" 
                            class="w-24 h-24 rounded-lg object-cover border-2 border-gray-200">
                    @else
                        <img src="{{ asset('images/default-company.png') }}" alt="{{ $perusahaan->nama_perusahaan }}" 
                            class="w-24 h-24 rounded-lg object-cover border-2 border-gray-200">
                    @endif
                </div>
                
                <!-- Company Info -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $perusahaan->nama_perusahaan }}</h1>
                    <p class="text-gray-600 text-lg leading-relaxed">{{ $perusahaan->keterangan }}</p>
                </div>
            </div>
            
            <!-- Edit Button -->
            <a href="{{ route('perusahaan.edit', ['perusahaanId' => $perusahaan->id]) }}" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                Edit Profil Perusahaan
            </a>
        </div>

        <!-- Navigation Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="flex space-x-8">
                <button wire:click="setActiveTab('home')" 
                        class="py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 {{ $activeTab === 'home' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Home
                </button>
                <button wire:click="setActiveTab('posts')" 
                        class="py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200 {{ $activeTab === 'posts' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Post
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        @if($activeTab === 'home')
            <!-- Home Tab Content -->
            <div class="space-y-8">
                <!-- Company Address -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">Alamat Perusahaan</h2>
                    <p class="text-gray-700">{{ $perusahaan->kota_id }}, {{ $perusahaan->provinsi_id }}</p>
                </div>

                <!-- Products Section -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Produk Perusahaan</h2>
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($products as $product)
                                <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                    @if($product->gambar_produk)
                                        <img src="{{ Storage::url($product->gambar_produk) }}" alt="{{ $product->nama_produk }}" 
                                            class="w-full h-32 object-cover rounded-md mb-3">
                                    @endif
                                    <h3 class="font-semibold text-gray-900 mb-2">{{ $product->nama_produk }}</h3>
                                    <p class="text-gray-600 text-sm">{{ $product->deskripsi }}</p>
                                    @if($product->harga)
                                        <p class="text-blue-600 font-semibold mt-2">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <p>Belum ada produk yang ditambahkan.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($activeTab === 'posts')
            <!-- Posts Tab Content -->
            <div class="space-y-6">
                <!-- Add Post Button -->
                <div class="flex justify-end">
                    <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                        Tambah Post
                    </button>
                </div>

                <!-- Posts List -->
                @if($posts->count() > 0)
                    <div class="space-y-6">
                        @foreach($posts as $post)
                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <div class="flex items-center space-x-3 mb-4">
                                    @if($perusahaan->logo)
                                        <img src="{{ Storage::url($perusahaan->logo) }}" alt="{{ $perusahaan->nama_perusahaan }}" 
                                            class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <img src="{{ asset('images/default-company.png') }}" alt="{{ $perusahaan->nama_perusahaan }}" 
                                            class="w-24 h-24 rounded-lg object-cover border-2 border-gray-200">
                                    @endif
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $perusahaan->nama_perusahaan }}</h3>
                                        <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                
                                <p class="text-gray-700 mb-4">{{ $post->konten }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>Belum ada postingan yang dibuat.</p>
                    </div>
                @endif
            </div>
        @endif
    @else
        <!-- No Company Profile -->
        <div class="text-center py-12">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Profil Perusahaan Belum Dibuat</h2>
            <p class="text-gray-600 mb-6">Silakan buat profil perusahaan Anda terlebih dahulu.</p>
            <a href="{{ route('perusahaan.create') }}" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                Buat Profil Perusahaan
            </a>
        </div>
    @endif
</div>
