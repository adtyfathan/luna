<div class="max-w-6xl mx-auto p-4 space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        @if ($user)
            {{-- sidebar --}}
            <div class="space-y-6">

                {{-- sidebar profil --}}
                <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 bg-gradient-to-br from-white to-blue-50/50">
                    <div class="flex items-center gap-4">
                        @if ($user->foto_profil)
                            <img class="h-10 w-10 object-cover rounded-full shadow-sm"
                                src="{{ Storage::url($user->foto_profil) }}" alt="{{ $user->name }}'s avatar">
                        @else
                            <div
                                class="h-10 w-10 rounded-full bg-gradient-to-br from-white to-blue-100 flex items-center justify-center shadow-sm">
                                <img class="h-10 w-10 object-cover rounded-full opacity-90"
                                    src="{{ asset('images/default-avatar.png') }}" alt="{{ $user->name }}'s avatar">
                            </div>
                        @endif

                        <div>
                            <a href="{{ route('pengguna', $user->id) }}" wire:navigate
                                class="font-bold text-gray-900">{{ $user->name }}</a>
                            <p class="text-gray-500 text-sm">{{ $user->headline }}</p>
                        </div>
                    </div>

                    @if ($user->provinsi || $user->kota)
                        <div class="flex items-center text-gray-500 my-4">
                            <svg class="h-4 w-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                            </svg>
                            <span class="text-sm">
                                @if ($user->kota && $user->provinsi)
                                    {{ $user->kota->nama_kota }}, {{ $user->provinsi->nama_provinsi }}
                                @elseif ($user->kota)
                                    {{ $user->kota->nama_kota }}
                                @elseif ($user->provinsi)
                                    {{ $user->provinsi->nama_provinsi }}
                                @endif
                            </span>
                        </div>
                    @endif

                    @php
                        $latestPengalaman = auth()->user()->pengalaman()->latest()->first();
                        // dump($latestPengalaman);
                    @endphp

                    @if ($latestPengalaman)

                        <div class="flex items-center text-gray-500 my-4">
                            <img class="h-8 w-8 mr-2 object-cover rounded-full opacity-90" src="{{ asset('images/google.png') }}"
                                alt="company logo">
                            <span class="text-sm">
                                {{ $latestPengalaman->nama_perusahaan }}
                            </span>
                        </div>
                    @endif

                    @php
                        $latestPendidikan = auth()->user()->pendidikan()->latest()->first();
                        // dump($latestPendidikan);
                    @endphp

                    @if ($latestPendidikan)
                        <div class="flex items-center text-gray-500 my-4">
                            <img class="h-8 w-8 mr-2 object-cover rounded-full opacity-90" src="{{ asset('images/unsoed.png') }}"
                                alt="pedidikan logo">
                            <span class="text-sm">
                                {{ $latestPendidikan->nama_institusi }}
                            </span>
                        </div>
                    @endif

                    <div class="space-y-3 my-3">
                        <a href="{{ route('pengguna', auth()->user()->id) }}" wire:navigate
                            class="flex items-center gap-2 text-sm text-gray-700 hover:text-black transition duration-100 bg-blue-50 p-3 hover:bg-blue-100 rounded-lg">
                            <svg class="h-5 w-5 text-gray-700 hover:text-black" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profil saya
                        </a>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('profile') }}" wire:navigate
                            class="flex items-center gap-2 text-sm text-gray-700 hover:text-black transition duration-100 bg-blue-50 p-3 hover:bg-blue-100 rounded-lg">
                            <svg class="h-5 w-5 text-gray-700 hover:text-black" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7h3l2-3h8l2 3h3v13H3V7z" />
                                <circle cx="12" cy="13" r="4" stroke-width="2" stroke="currentColor" fill="none" />
                            </svg>

                            Kelola postingan
                        </a>
                    </div>
                </div>

                @if ($perusahaanUser)
                    {{-- sidebar umkm --}}
                    <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 bg-gradient-to-br from-white to-blue-50/50">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                            <div
                                class="h-6 w-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-md flex items-center justify-center mr-2">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 21V9a1 1 0 011-1h3V4a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v12" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 21h16M8 13h.01M8 17h.01M12 13h.01M12 17h.01M16 13h.01M16 17h.01" />
                                </svg>

                            </div>
                            UMKM Saya
                        </h3>

                        @forelse ($perusahaanUser as $perusahaan)
                            <div class="space-y-3 my-3">
                                <a href="{{ route('perusahaan.index', $perusahaan->id) }}" wire:navigate
                                    class="flex items-center gap-2 text-sm text-gray-700 hover:text-black transition duration-100 bg-blue-50 p-3 hover:bg-blue-100 rounded-lg">
                                    <img src="{{ $perusahaan->logo ? asset('storage/' . $perusahaan->logo) : asset('images/default-company.png') }}"
                                        alt="Company Logo" class="w-8 h-8 rounded-full object-cover ">

                                    {{ $perusahaan->nama_perusahaan }}
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-700 leading-relaxed text-sm">Belum ada UMKM</p>
                        @endforelse
                    </div>
                @endif
            </div>
        @endif

        <div class="lg:col-span-3 space-y-6">
            @foreach ($posts as $post)
                @if ($post->author_type === 'App\Models\User' || $post->author_type === 'App\Models\Perusahaan')
                    <!-- Post Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <!-- Author Info -->
                        <div class="flex items-center gap-4 p-4 cursor-pointer"
                            wire:click="redirectToPost({{ $post->id }}, '{{ $post->author_type }}')">
                            @php
        $avatar = $post->author_type === 'App\\Models\\User'
            ? ($post->author->foto_profil ? Storage::url($post->author->foto_profil) : asset('images/default-avatar.png'))
            : ($post->author->logo ? Storage::url($post->author->logo) : asset('images/default-company.png'));
                            @endphp
                            <img src="{{ $avatar }}" class="h-14 w-14 object-cover rounded-full border border-gray-300">

                            <div>
                                <h2 class="text-gray-900 font-semibold text-sm sm:text-base hover:underline">
                                    @if ($post->author_type === 'App\\Models\\User')
                                        <a href="{{ route('pengguna', $post->author->id) }}" wire:navigate>{{ $post->author->name }}</a>
                                    @else
                                        <a href="{{ route('perusahaan.index', $post->author->id) }}"
                                            wire:navigate>{{ $post->author->nama_perusahaan }}</a>
                                    @endif
                                </h2>
                                <p class="text-gray-500 text-xs sm:text-sm">
                                    {{ $post->author->headline ?? '' }}
                                </p>
                                <span class="text-gray-400 text-xs">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Post Content -->
                        <div class="px-4 pb-4">
                            <p class="text-gray-800 text-sm sm:text-base mb-3 whitespace-pre-line">
                                {{ $post->konten }}
                            </p>

                            <!-- Post Images -->
                            @if($post->gambarPost->count() > 0)
                                @if($post->gambarPost->count() === 1)
                                    <div class="rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $post->gambarPost->first()->url) }}"
                                            class="w-full max-h-[500px] object-cover">
                                    </div>
                                @else
                                    <div class="grid grid-cols-2 gap-1 rounded-lg overflow-hidden">
                                        @foreach($post->gambarPost->take(4) as $index => $image)
                                            <div class="relative">
                                                <img src="{{ asset('storage/' . $image->url) }}" class="w-full h-48 object-cover">
                                                @if($loop->last && $post->gambarPost->count() > 4)
                                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                                        <span class="text-white font-semibold text-lg">+{{ $post->gambarPost->count() - 3 }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="border-t border-gray-100 flex justify-around text-sm text-gray-500">
                            <!-- Like -->
                            <button wire:click="toggleLike({{ $post->id }})"
                                class="flex items-center gap-2 py-3 px-4 hover:bg-gray-50 w-full justify-center">
                                <svg class="w-5 h-5 {{ $post->like->where('user_id', Auth::id())->count() ? 'text-red-500' : 'text-gray-400' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 
                                                            115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                </svg>
                                <span>{{ $post->like->count() }} Suka</span>
                            </button>

                            <!-- Comment -->
                            <div class="flex items-center gap-2 py-3 px-4 hover:bg-gray-50 w-full justify-center cursor-pointer">
                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 
                                                                  01-4.083-.98L2 17l1.338-3.123C2.493 12.767 
                                                                  2 11.434 2 10c0-3.866 3.582-7 
                                                                  8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 
                                                                  0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ $post->komentar->count() }} Komentar</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

    </div>
</div>