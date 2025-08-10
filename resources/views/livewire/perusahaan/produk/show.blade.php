<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 pt-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('perusahaan.index', ['perusahaanId' => $perusahaanId]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Product Details Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif


                                    {{-- Product Detail Layout --}}
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                        {{-- Product Image - Left Side --}}
                                        <div class="space-y-4">
                                            <div class="aspect-rectangle bg-gray-100 rounded-lg overflow-hidden relative group">
                                                @if($gambar)
                                                    <img 
                                                        src="{{ Storage::url($gambar) }}" 
                                                        alt="{{ $namaProduk }}"
                                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                                    >
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </div>
                                                @endif

                                                {{-- Action Buttons --}}
                                                @if ($isOwner)
                                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                                        <div class="flex space-x-2">
                                                            <a href="{{ route('perusahaan.produk.edit', ['produkId' => $produkId]) }}" 
                                                            class="p-2 bg-white rounded-full text-gray-700 hover:text-blue-600 transition-colors">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>

                                        {{-- Product Information - Right Side --}}
                                        <div class="space-y-6">
                                            {{-- Row 1: Product Name & Price --}}
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1 pr-4">
                                                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight">
                                                        {{ $namaProduk }}
                                                    </h1>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-2xl lg:text-3xl font-bold text-blue-600">
                                                        Rp {{ number_format($hargaProduk, 0, ',', '.') }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 mt-1">Harga per unit</p>
                                                </div>
                                            </div>

                                            {{-- Row 2: Category --}}
                                            <div>
                                                <h3 class="text-sm font-medium text-gray-700 mb-2">Kategori</h3>
                                                @if($kategoriProduk)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                                        </svg>
                                                        {{ $kategoriProduk }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                        Tidak ada kategori
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Row 3: Description --}}
                                            <div>
                                                <h3 class="text-sm font-medium text-gray-700 mb-3">Deskripsi Produk</h3>
                                                <div class="prose prose-sm max-w-none">
                                                    <p class="text-gray-600 leading-relaxed">
                                                        {{ $deskripsiProduk ?: 'Tidak ada deskripsi tersedia.' }}
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- Additional Product Info --}}
                                            <div class="border-t pt-6">
                                                <h3 class="text-sm font-medium text-gray-700 mb-4">Informasi Tambahan</h3>
                                                <div class="grid grid-cols-2 gap-4 text-sm">
                                                    <div>
                                                        <span class="text-gray-500">Ditambahkan:</span>
                                                        <p class="font-medium text-gray-900">{{ $createdAt->format('d M Y') }}</p>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-500">Terakhir diupdate:</span>
                                                        <p class="font-medium text-gray-900">{{ $updatedAt->format('d M Y') }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Contact Information --}}
                                            <div class="bg-gray-50 rounded-lg p-4">
                                                <h3 class="text-sm font-medium text-gray-700 mb-3">Hubungi Penjual</h3>
                                                <div class="space-y-2">
                                                    <div class="flex items-center text-sm text-gray-600">
                                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                                        </svg>
                                                        +62 812-3456-7890
                                                    </div>
                                                    <div class="flex items-center text-sm text-gray-600">
                                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                        </svg>
                                                        Kota Banda Aceh, DKI Jakarta
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


        </div>
    </div>
</div>
