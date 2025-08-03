<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="grid grid-cols-1 lg:grid-cols-3 sm:gap-4 lg:gap-12">

            <div class="lg:col-span-2 space-y-6">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Tambahkan Koneksi</h1>
                    <p class="mt-2 text-gray-600">Cari dan Tambahkan Koneksi Untuk Membangung Profilmu</p>
                </div>
                
                <!-- Search and Filters Section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                    <!-- Main Search Bar -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Cari..."
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                </div>
                
                <!-- Results Count -->
                @if($users->total() > 0)
                    <div class="mb-6">
                        <p class="text-sm text-gray-700">
                            Showing {{ $users->firstItem() }}-{{ $users->lastItem() }} of {{ $users->total() }} people
                            @if($search)
                                for "<span class="font-semibold">{{ $search }}</span>"
                            @endif
                        </p>
                    </div>
                @endif
                
                <!-- Users Grid -->
                <div class="flex flex-col space-y-4 mb-8">
                    @forelse($users as $user)
                        <div
                            class="flex items-center bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 px-6 py-4">
                            <!-- Profile Image -->
                            <div class="flex-shrink-0">
                                @if($user->foto_profil)
                                    <img class="h-16 w-16 rounded-full object-cover border-4 border-white shadow-sm"
                                        src="{{ Storage::url($user->foto_profil) }}" alt="{{ $user->name }}">
                                @else
                                    <img class="h-16 w-16 object-cover rounded-full opacity-90" src="{{ asset('images/default-avatar.png') }}"
                                        alt="{{ $user->name }}'s avatar">
                                @endif
                            </div>
                            <!-- User Info -->
                            <div class="ml-6 flex-1 min-w-0">
                                <a href="{{ route('pengguna', $user->id) }}" class="text-lg font-semibold text-gray-900 truncate" wire:navigate>{{ $user->name }}</a>
                                @if($user->headline)
                                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $user->headline }}</p>
                                @endif
                            </div>
                            <!-- Action Buttons -->
                            <div class="flex space-x-2 ml-6">
                                @auth
                                    @if(auth()->id() !== $user->id)
                                        <button wire:click="followUser({{ $user->id }})" class="px-5 py-2 rounded-md text-sm font-semibold transition-all duration-200 shadow-sm
                                            bg-gradient-to-r
                                            {{ auth()->user()->following->contains($user->id)
                ? 'from-white-200 to-blue-100 text-black hover:bg-blue-100 border border-blue-200'
                : 'from-blue-500 to-blue-700 text-white hover:from-blue-600 hover:to-blue-800 border border-blue-500'
                                            }}">
                                            @if(auth()->user()->following->contains($user->id))
                                                <svg class="inline h-4 w-4 mr-1 text-blue-700" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span>Following</span>
                                            @else
                                                <span>Follow</span>
                                            @endif
                                        </button>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @empty

                    @endforelse
                </div>
                
                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="flex justify-center">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

            <div class="lg:col-span-1 space-y-6 w-full">
                <!-- Aktivitas -->
                <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 bg-gradient-to-br from-white to-blue-50/50">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                        <div
                            class="h-6 w-6 bg-gradient-to-r from-purple-500 to-purple-600 rounded-md flex items-center justify-center mr-2">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        Aktivitas
                    </h3>
                        @forelse ($aktivitases as $aktivitas)
                            <div
                                class="mb-4 flex items-center justify-between p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 hover:border-gray-200">
                                <div class="flex items-center space-x-4">
                                    @if ($aktivitas->follower->foto_profil)
                                        <img class="h-10 w-10 object-cover rounded-full shadow-lg ring-1 ring-white"
                                            src="{{ Storage::url($aktivitas->follower->foto_profil) }}" alt="{{ $aktivitas->follower->name }}'s avatar">
                                    @else
                                        <img class="h-10 w-10 object-cover rounded-full opacity-90 ring-1 ring-white"
                                            src="{{ asset('images/default-avatar.png') }}" alt="{{ $aktivitas->follower->name }}'s avatar">
                                    @endif

                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900 text-sm">{{ $aktivitas->follower->name }}</p>
                                        <p class="text-gray-500 text-xs flex items-center">
                                            Mengikuti anda
                                        </p>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <p class="text-xs text-gray-500 font-medium">{{ $this->formatCreatedAt($aktivitas->created_at) }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <p class="text-sm font-medium">Belum ada aktivitas</p>
                            </div>
                        @endforelse
                </div>
            </div>

        </div>

    </div>
</div>