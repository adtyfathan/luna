<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header Section  -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Buat UMKM Anda!</h1>
            <p class="text-lg text-gray-600">Mulai perjalanan bisnis Anda bersama kami. Daftarkan UMKM Anda dan jangkau lebih banyak pelanggan.</p>
        </div>

        <!-- Form Card  -->
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

            <form wire:submit="createCompany" class="space-y-6">
                <!-- Logo/Photo Upload  -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Logo UMKM <span class="text-gray-400">(Opsional)</span>
                    </label>
                    <div class="flex items-center justify-center w-full">
                        <label for="logo"
                            class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                
                            @if ($logo)
                                <!-- Preview uploaded image -->
                                <img src="{{ $logo->temporaryUrl() }}" alt="Preview Logo" class="h-32 object-contain rounded-lg mb-2">

                                <p class="text-sm text-green-600 font-medium">
                                    {{ $logo->getClientOriginalName() }}
                                </p>
                                <p class="text-xs text-gray-500">Klik untuk mengganti</p>
                            @else
                                <!-- Placeholder if no image yet -->
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Klik untuk upload</span> logo UMKM
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG atau JPEG (MAX. 2MB)</p>
                                </div>
                            @endif
                
                            <input id="logo" type="file" wire:model="logo" accept="image/*" class="hidden">
                        </label>
                    </div>
                    @error('logo')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>


                <!-- Nama UMKM  -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama UMKM <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" wire:model="nama_perusahaan" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                            placeholder="Contoh: Warung Makan Bu Sari"
                            required>
                    @error('nama_perusahaan') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="headline" class="block text-sm font-medium text-gray-700 mb-2">
                        Headline UMKM 
                    </label>
                    <input type="text" id="headline" wire:model="headline"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                        placeholder="Contoh: Warteg Modern">
                    @error('headline') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Deskripsi UMKM  -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi UMKM
                    </label>
                    <textarea id="keterangan" wire:model="keterangan" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                placeholder="Ceritakan tentang UMKM Anda, produk atau layanan yang ditawarkan, dan keunggulan yang dimiliki..."></textarea>
                    @error('keterangan') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Kota dan Provinsi  -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kota UMKM  -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                            Kota UMKM <span class="text-red-500">*</span>
                        </label>
                        <select id="city" wire:model="kota"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required>
                            <option value="">Pilih Kota</option>
                            @foreach ($kotas as $kotaData)
                                <option value="{{ $kotaData->id }}">{{ $kotaData->nama_kota }}</option>
                            @endforeach
                        </select>
                        @error('kota') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Provinsi UMKM  -->
                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 mb-2">
                            Provinsi UMKM <span class="text-red-500">*</span>
                        </label>
                        <select id="province" wire:model="provinsi" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" required>
                            <option value="">Pilih Provinsi</option>
                            @foreach ($provinsis as $provinsiData)
                                <option value="{{ $provinsiData->id }}">{{ $provinsiData->nama_provinsi }}</option>
                            @endforeach
                        </select>
                        @error('provinsi') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Submit Button  -->
                <div class="pt-4">
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Buat UMKM Saya
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Benefits Section  -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-6 bg-white rounded-lg shadow-sm">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Mudah & Cepat</h3>
                <p class="text-sm text-gray-600">Daftarkan UMKM Anda hanya dalam beberapa menit</p>
            </div>

            <div class="text-center p-6 bg-white rounded-lg shadow-sm">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Jangkau Lebih Banyak</h3>
                <p class="text-sm text-gray-600">Temukan pelanggan baru di seluruh Indonesia</p>
            </div>

            <div class="text-center p-6 bg-white rounded-lg shadow-sm">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Analisis Bisnis</h3>
                <p class="text-sm text-gray-600">Dapatkan insight untuk mengembangkan bisnis</p>
            </div>
        </div>
    </div>
</div>