<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 pt-6">

    <!-- Profile Header Section -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div
            class="bg-gradient-to-r from-blue-100 via-pink-100 to-purple-100 shadow-md border border-blue-100 rounded-lg">
            <div class="p-8">
                <!-- Profile Header -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                    <!-- Profile Picture -->
                    <div class="relative flex-shrink-0">
                        @if ($user->foto_profil)
                            <img class="h-32 w-32 object-cover rounded-full shadow-lg ring-4 ring-white"
                                src="{{ Storage::url($user->foto_profil) }}" alt="{{ $user->name }}'s avatar">
                        @else
                            <div
                                class="h-32 w-32 rounded-full bg-gradient-to-br from-white to-blue-100 flex items-center justify-center shadow-md ring-4 ring-white">
                                <img class="h-28 w-28 object-cover rounded-full opacity-90"
                                    src="{{ asset('images/default-avatar.png') }}" alt="{{ $user->name }}'s avatar">
                            </div>
                        @endif
                    </div>

                    

                    <!-- Profile Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <div class="flex-1">
                                <!-- Name and Headline -->
                                <h1 class="text-2xl sm:text-3xl font-bold text-black mb-2 drop-shadow-sm">
                                    {{ $user->name }}</h1>

                                @if ($user->headline)
                                    <p class="text-lg text-black-100 mb-3 leading-relaxed">{{ $user->headline }}</p>
                                @endif

                                <!-- Location -->
                                @if ($user->provinsi || $user->kota)
                                    <div class="flex items-center text-gray-500 mb-4">
                                        <svg class="h-4 w-4 mr-2 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
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

                                <!-- Connection Stats -->
                                <div class="flex items-center gap-6 mb-4">
                                    <button wire:click="showFollowers"
                                        class="text-sm font-medium text-black hover:text-blue-200 transition-colors duration-200 bg-black/10 px-3 py-1 rounded-full backdrop-blur-sm">
                                        <span class="font-bold">{{ number_format($followerCount) }}</span> Followers
                                    </button>
                                    <button wire:click="showFollowing"
                                        class="text-sm font-medium text-black hover:text-blue-200 transition-colors duration-200 bg-black/10 px-3 py-1 rounded-full backdrop-blur-sm">
                                        <span class="font-bold">{{ number_format($followingCount) }}</span> Following
                                    </button>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            @if (Auth::check() && Auth::id() !== $user->id)
                                                    <div class="flex flex-col sm:flex-row gap-3">
                                                        <button wire:click="toggleFollow" class="px-6 py-3 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 shadow-lg
                                                                            {{ $isFollowing
        ? 'bg-white/20 text-black hover:bg-white/30 border border-white/30 backdrop-blur-sm'
        : 'bg-white text-blue-600 hover:bg-blue-50 shadow-white/25' }}">
                                                            {{ $isFollowing ? 'Following' : 'Follow' }}
                                                        </button>

                                                        <button
                                                            class="px-6 py-3 border border-black/30 text-black rounded-lg font-medium hover:bg-white/10 transition-all duration-200 transform hover:scale-105 backdrop-blur-sm">
                                                            Message
                                                        </button>
                                                    </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="relative inline-block">
            <button wire:click="setActiveTab('profil')" class="font-bold text-xl px-6 mb-2">
                Profil
            </button>
            @if ($activeTab === 'profil')
                <div
                    class="absolute mx-4 bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-200 via-blue-300 to-blue-400 rounded-full">
                </div>
            @endif
        </div>

        <div class="relative inline-block">
            <button wire:click="setActiveTab('post')" class="font-bold text-xl px-6 mb-2">
                Post
            </button>
            @if ($activeTab === 'post')
                <div
                    class="absolute mx-4 bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-200 via-blue-300 to-blue-400 rounded-full">
                </div>
            @endif
        </div>
    </div>

    <!-- Profile Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Main Content Area -->
            <div class="lg:col-span-3 space-y-6">
                @if ($activeTab === 'profil')
                    <!-- About Section -->
                    <div
                        class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 bg-gradient-to-br from-white to-blue-50/50">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <div
                                class="h-8 w-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            Profil
                        </h2>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $user->keterangan ? $user->keterangan : "Belum ada informasi profil" }}</p>
                    </div>

                    <!-- Experience Section -->
                    <div
                        class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 bg-gradient-to-br from-white to-blue-50/50">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <div
                                class="h-8 w-8 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            Pengalaman
                        </h2>

                        <div class="space-y-6 mt-6">
                            @forelse($user->pengalaman as $pengalaman)
                                <div class="my-2 p-4 border-b hover:shadow-md rounded-md transition duration-200">
                                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                                        <!-- Main Content -->
                                        <div class="flex-1">
                                            <div class="flex items-start space-x-4">
                                                <!-- Company Logo -->
                                                <div class="flex-shrink-0 mr-4">
                                                    @if($pengalaman->perusahaan && $pengalaman->perusahaan->logo)
                                                        <img class="w-12 h-12 rounded-lg object-cover border border-gray-200"
                                                            src="{{ Storage::url($pengalaman->perusahaan->logo) }}"
                                                            alt="{{ $pengalaman->perusahaan->nama_perusahaan ?? $pengalaman->nama_perusahaan }}">
                                                    @else
                                                        <img src="{{ asset('images/default-company.png') }}"
                                                            class="w-12 h-12 rounded-lg flex items-center justify-center shadow-md bg-blue-100"
                                                            alt="default perusahaan image">
                                                    @endif
                                                </div>

                                                <!-- Job Details -->
                                                <div class="flex-1 min-w-0">
                                                    <div
                                                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                                                        <h3 class="text-xl font-semibold text-gray-900 truncate">
                                                            {{ $pengalaman->jabatan }}
                                                        </h3>
                                                        <div
                                                            class="mt-2 sm:mt-0 sm:ml-4 flex justify-center items-center gap-4">
                                                            <span
                                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getJobTypeBadgeColor($pengalaman->tipe_pekerjaan) }}">
                                                                {{ $this->getJobTypeLabel($pengalaman->tipe_pekerjaan) }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center text-gray-600 mb-2">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                            </path>
                                                        </svg>
                                                        <span class="text-sm font-medium">
                                                            {{ $pengalaman->perusahaan->nama_perusahaan ?? $pengalaman->nama_perusahaan }}
                                                        </span>
                                                    </div>

                                                    <div
                                                        class="flex flex-col sm:flex-row sm:items-center text-gray-500 text-sm space-y-1 sm:space-y-0 sm:space-x-4 mb-2">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4M8 7H3a1 1 0 00-1 1v10a1 1 0 001 1h18a1 1 0 001-1V8a1 1 0 00-1-1h-5M8 7v13M16 7v13">
                                                                </path>
                                                            </svg>
                                                            {{ $this->formatDate($pengalaman->tanggal_mulai) }} -
                                                            {{ $pengalaman->tanggal_selesai ? $this->formatDate($pengalaman->tanggal_selesai) : 'Sekarang' }}
                                                        </div>
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            @if ($pengalaman->tanggal_mulai && $pengalaman->tanggal_selesai)
                                                                {{ $this->calculateDuration($pengalaman->tanggal_mulai, $pengalaman->tanggal_selesai) }}
                                                            @endif
                                                        </div>
                                                    </div>

                                                    @if($pengalaman->lokasi)
                                                        <div class="flex items-center text-gray-500 text-sm mb-3">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                                </path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            </svg>
                                                            {{ $pengalaman->lokasi }}
                                                        </div>
                                                    @endif

                                                    @if($pengalaman->deskripsi)
                                                        <div class="prose prose-sm max-w-none text-gray-700">
                                                            <p>{{ $pengalaman->deskripsi }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>Belum ada informasi pengalaman</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Education Section -->
                    <div
                        class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 bg-gradient-to-br from-white to-blue-50/50">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <div
                                class="h-8 w-8 bg-gradient-to-r from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            Riwayat Pendidikan
                        </h2>

                        <div class="space-y-6 mt-6">
                            @forelse($user->pendidikan as $pendidikan)
                                <div class="my-2 p-4 border-b hover:shadow-md rounded-md transition duration-200">
                                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                                        <!-- Main Content -->
                                        <div class="flex-1">
                                            <div class="flex items-start space-x-4">
                                                <!-- Education Logo -->
                                                <div class="flex-shrink-0 mr-4">
                                                    @if($pendidikan->institusiPendidikan && $pendidikan->institusiPendidikan->logo)
                                                        <img class="w-12 h-12 rounded-lg object-cover border border-gray-200"
                                                            src="{{ Storage::url($pendidikan->institusiPendidikan->logo) }}"
                                                            alt="{{ $pendidikan->institusiPendidikan->nama_institusi ?? $pendidikan->nama_institusi }}">
                                                    @else
                                                        <img src="{{ asset('images/default-pendidikan.png') }}"
                                                            class="w-12 h-12 rounded-lg flex items-center justify-center shadow-md bg-blue-100"
                                                            alt="default pendidikan image">
                                                    @endif
                                                </div>

                                                <!-- Education Details -->
                                                <div class="flex-1 min-w-0">
                                                    <div
                                                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                                                        <h3 class="text-xl font-semibold text-gray-900 truncate">
                                                            @if ($pendidikan->institusiPendidikan)
                                                                {{ $pendidikan->institusiPendidikan->nama_institusi }}
                                                            @else
                                                                {{ $pendidikan->nama_institusi }}
                                                            @endif
                                                        </h3>
                                                        <div
                                                            class="mt-2 sm:mt-0 sm:ml-4 flex justify-center items-center gap-4">
                                                            @if ($pendidikan->tingkat)
                                                                <span
                                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getTingkatBadgeColor($pendidikan->tingkat) }}">
                                                                    {{ $pendidikan->tingkat }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    @if ($pendidikan->jurusan)
                                                        <div class="flex items-center text-gray-600 mb-2">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                                </path>
                                                            </svg>
                                                            <span class="text-sm font-medium">
                                                                {{ $pendidikan->jurusan }}
                                                            </span>
                                                        </div>
                                                    @endif

                                                    <div
                                                        class="flex flex-col sm:flex-row sm:items-center text-gray-500 text-sm space-y-1 sm:space-y-0 sm:space-x-4 mb-2">
                                                        <div class="flex items-center">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4M8 7H3a1 1 0 00-1 1v10a1 1 0 001 1h18a1 1 0 001-1V8a1 1 0 00-1-1h-5M8 7v13M16 7v13">
                                                                </path>
                                                            </svg>
                                                            {{ $this->formatDate($pendidikan->tanggal_mulai) }} -
                                                            {{ $pendidikan->tanggal_selesai ? $this->formatDate($pendidikan->tanggal_selesai) : 'Sekarang' }}
                                                        </div>
                                                        @if ($pendidikan->tanggal_mulai && $pendidikan->tanggal_selesai)
                                                            <div class="flex items-center">
                                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                                {{ $this->calculateDuration($pendidikan->tanggal_mulai, $pendidikan->tanggal_selesai) }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if($pendidikan->ipk)
                                                        <div class="flex items-center text-gray-500 text-sm mb-3">
                                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                                <path
                                                                    d="M12 2l2.9 6.9 7.1.6-5.2 4.9 1.6 7.1L12 17.8 5.6 21.5l1.6-7.1L2 9.5l7.1-.6L12 2z" />
                                                            </svg>
                                                            IPK: {{ $pendidikan->ipk }}
                                                        </div>
                                                    @endif

                                                    @if($pendidikan->deskripsi)
                                                        <div class="prose prose-sm max-w-none text-gray-700">
                                                            <p>{{ $pendidikan->deskripsi }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p>Belum ada informasi pendidikan</p>
                            @endforelse
                        </div>
                    </div>

                @elseif ($activeTab === 'post')
                    <!-- Posts Section -->
                    <div
                        class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 bg-gradient-to-br from-white to-blue-50/50">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <div
                                class="h-8 w-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            Postingan
                        </h2>

                        @forelse ($posts as $post)
                            <div
                                class="bg-white cursor-pointer my-4 border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200"
                                wire:click="redirectToPost({{ $post->id }})">
                                <!-- Post Header -->
                                <div class="p-6 border-b border-gray-100">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-3">
                                            <img src="{{ $user->foto_profil ? asset('storage/' . $user->foto_profil) : asset('images/default-avatar.png') }}"
                                                alt="Profile"
                                                class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                                            <div>
                                                <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                                                @if ($user->headline)
                                                    <p class="text-sm text-gray-500">{{ $user->headline }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mt-1 text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Post Content -->
                                <div class="p-6">
                                    <div class="prose max-w-none">
                                        <p class="text-gray-800 leading-relaxed mb-4">{{ $post->konten }}</p>
                                    </div>

                                    <!-- Post Images -->
                                    @if($post->gambarPost->count() > 0)
                                        <div class="mt-4">
                                            @if($post->gambarPost->count() == 1)
                                                <div class="rounded-lg overflow-hidden">
                                                    <img src="{{ asset('storage/' . $post->gambarPost->first()->url) }}"
                                                        alt="Post image" class="w-full max-h-96 object-cover">
                                                </div>
                                            @else
                                                <div class="grid grid-cols-2 gap-2">
                                                    @foreach($post->gambarPost->take(4) as $index => $image)
                                                        <div
                                                            class="relative rounded-lg overflow-hidden {{ $index >= 2 ? 'hidden sm:block' : '' }}">
                                                            <img src="{{ asset('storage/' . $image->url) }}" alt="Post image"
                                                                class="w-full h-48 object-cover">
                                                            @if($loop->last && $post->gambarPost->count() > 4)
                                                                <div
                                                                    class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                                                    <span
                                                                        class="text-white font-semibold text-lg">+{{ $post->gambarPost->count() - 3 }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Engagement Summary -->
                                    <div class="mt-6 pt-4 border-t flex gap-4 border-gray-100">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex items-center text-red-500">
                                                <button wire:click="toggleLike({{ $post->id }})">
                                                    <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <span class="font-medium">{{ $post->like->count() }}</span>
                                            </div>
                                            <span class="text-gray-400">suka</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <div class="flex items-center text-blue-500">
                                                <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="font-medium">{{ $post->komentar->count() }}</span>
                                            </div>
                                            <span class="text-gray-400">komentar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-700 leading-relaxed">Belum ada postingan</p>
                        @endforelse
                    </div>
                @endif
            </div>

            <!-- Sidebar - Always Present -->
            <div class="space-y-6">
                <!-- Contact Info -->
                <div
                    class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 bg-gradient-to-br from-white to-blue-50/50">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                        <div
                            class="h-6 w-6 bg-gradient-to-r from-blue-500 to-blue-600 rounded-md flex items-center justify-center mr-2">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        Informasi Kontak
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center text-sm text-gray-600 bg-blue-50/50 p-3 rounded-lg">
                            <span>{{ $user->email }}</span>
                        </div>
                    </div>
                </div>

                <!-- Suggestions -->
                <div
                    class="bg-white rounded-xl shadow-lg border border-blue-100 p-6 bg-gradient-to-br from-white to-blue-50/50">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                        <div
                            class="h-6 w-6 bg-gradient-to-r from-purple-500 to-purple-600 rounded-md flex items-center justify-center mr-2">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        Rekomendasi koneksi
                    </h3>
                    <div class="text-center py-8 text-gray-500">
                        <div
                            class="h-12 w-12 bg-gradient-to-br from-purple-100 to-purple-200 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium">Suggestions will appear here</p>
                        <p class="text-xs text-gray-400 mt-1">Connect with professionals in your network</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Followers Modal -->
    @if ($showFollowersModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:click="closeModals">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    wire:click.stop>
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Followers</h3>
                            <button wire:click="closeModals" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div>
                            @forelse ($user->follower as $follower)
                                <div class="py-3 flex items-center gap-4">
                                    @if ($follower->foto_profil)
                                        <img class="h-10 w-10 object-cover rounded-full shadow-lg ring-1 ring-white"
                                            src="{{ Storage::url($follower->foto_profil) }}" alt="{{ $follower->name }}'s avatar">
                                    @else
                                        <img class="h-10 w-10 object-cover rounded-full opacity-90 ring-1 ring-white"
                                            src="{{ asset('images/default-avatar.png') }}" alt="{{ $follower->name }}'s avatar">
                                    @endif

                                    <a href="{{ route('pengguna', $follower->id) }}" wire:navigate>{{ $follower->name }}</a>
                                </div>
                            @empty
                                <p>Tidak ada Followers</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Following Modal -->
    @if ($showFollowingModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:click="closeModals">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    wire:click.stop>
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Following</h3>
                            <button wire:click="closeModals" class="text-gray-400 hover:text-gray-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="">
                            @forelse ($user->following as $following)
                                <div class="py-3 flex items-center gap-4">
                                    @if ($following->foto_profil)
                                        <img class="h-10 w-10 object-cover rounded-full shadow-lg ring-1 ring-white"
                                            src="{{ Storage::url($following->foto_profil) }}" alt="{{ $following->name }}'s avatar">
                                    @else
                                        <img class="h-10 w-10 object-cover rounded-full opacity-90 ring-1 ring-white"
                                            src="{{ asset('images/default-avatar.png') }}" alt="{{ $following->name }}'s avatar">
                                    @endif

                                    <a href="{{ route('pengguna', $following->id) }}" wire:navigate>{{ $following->name }}</a>
                                </div>
                            @empty
                                <p>Tidak ada Following</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>