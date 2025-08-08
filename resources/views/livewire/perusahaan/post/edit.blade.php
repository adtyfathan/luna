<div class="max-w-2xl my-2 border-b rounded-md bg-white m-auto p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-black">Edit Post</h1>
        <p class="text-gray-600 mt-2">Bagikan pemikiranmu dengan dunia!</p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('warning'))
        <div class="mb-6 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg">
            {{ session('warning') }}
        </div>
    @endif

    <!-- Edit Post Form -->
    <form wire:submit="updatePost" class="space-y-6">
        <!-- Content Input -->
        <div>
            <label for="konten" class="block text-sm font-medium text-gray-500 mb-2">
                Tulis apa yang kamu pikirkan
            </label>
            <textarea wire:model="konten" id="konten" rows="4"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>

            @error('konten')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <!-- Character Counter -->
            <div class="mt-2 text-right">
                <span class="text-sm text-gray-500">
                    {{ strlen($konten) }}/5000 karakter
                </span>
            </div>
        </div>

        <!-- Image Upload Section -->
        <div>
            <!-- Upload Button -->
            <div class="flex items-center space-x-4 mb-4">
                <label for="images"
                    class="cursor-pointer inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    Pilih Gambar
                </label>
                <input type="file" id="images" wire:model="newImages" multiple accept="image/*" class="hidden">

                <span class="text-sm text-gray-500">
                    Maksimum 5 mb
                </span>
            </div>

            @error('newImages.*')
                <p class="mb-4 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <!-- Loading Indicator -->
            <div wire:loading wire:target="newImages" class="mb-4">
                <div class="flex items-center text-blue-600">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Upload Gambar...
                </div>
            </div>

            <!-- Image Counter -->
            @if ($this->totalImages > 0)
                <div class="mb-4">
                    <span class="text-sm text-gray-600">
                        {{ $this->totalImages }}/10 gambar terpilih
                    </span>
                </div>
            @endif

            <!-- Existing Images -->
            @if (count($existingImages) > 0)
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Gambar saat ini</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($existingImages as $image)
                            <div class="relative group">
                                @if(in_array($image->id, $imagesToDelete))
                                    <!-- Marked for deletion -->
                                    <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden opacity-50 relative">
                                        <img src="{{ asset('storage/' . $image->url) }}" alt="Existing image"
                                            class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-red-500 bg-opacity-50 flex items-center justify-center">
                                            <span class="text-white text-xs font-medium">Akan dihapus</span>
                                        </div>
                                    </div>

                                    <!-- Restore Button -->
                                    <button type="button" wire:click="restoreExistingImage({{ $image->id }})"
                                        class="absolute -top-2 -right-2 bg-green-500 hover:bg-green-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                        title="Restore image">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                @else
                                    <!-- Normal display -->
                                    <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $image->url) }}" alt="Existing image"
                                            class="w-full h-full object-cover">
                                    </div>

                                    <!-- Remove Button -->
                                    <button type="button" wire:click="removeExistingImage({{ $image->id }})"
                                        class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                        title="Mark for deletion">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- New Images Previews -->
            @if (count($images) > 0)
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Gambar yang akan ditambahkan</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($images as $index => $image)
                            <div class="relative group">
                                <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden">
                                    <img src="{{ $image->temporaryUrl() }}" alt="New image {{ $index + 1 }}"
                                        class="w-full h-full object-cover">
                                </div>

                                <!-- Remove Button -->
                                <button type="button" wire:click="removeNewImage({{ $index }})"
                                    class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ route('perusahaan.post.show', $post->id) }}"
                class="px-6 py-2 text-gray-600 hover:text-gray-800 transition-colors duration-200" wire:navigate>
                Kembali
            </a>

            <button type="submit" wire:loading.attr="disabled" wire:target="updatePost"
                class="px-8 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-medium rounded-lg transition-colors duration-200 flex items-center">

                <span wire:loading.remove wire:target="updatePost">
                    Update Postingan
                </span>

                <span wire:loading wire:target="updatePost" class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Menyimpan...
                </span>
            </button>
        </div>
    </form>
</div>