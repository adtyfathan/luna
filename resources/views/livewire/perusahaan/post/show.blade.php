<div class="max-w-4xl my-4 mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
    <!-- Post Header -->
    <div class="flex items-center p-4 border-b border-gray-200">
        <div class="flex-shrink-0">
            @if($post->author->logo)
                <img class="h-12 w-12 rounded-full object-cover" src="{{ asset('storage/' . $post->author->logo) }}"
                    alt="{{ $post->author->nama_perusahaan }}">
            @else
                <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                    <span class="text-gray-600 font-medium">{{ substr($post->author->nama_perusahaan, 0, 1) }}</span>
                </div>
            @endif
        </div>
        <div class="ml-3 flex-1">
            <div class="flex items-center">
                <a href="{{ route('perusahaan.index', $post->author->id) }}" wire:navigate
                    class="text-sm font-semibold text-gray-900">{{ $post->author->nama_perusahaan }}</a>
            </div>
            @if(isset($post->author->headline))
                <p class="text-xs text-gray-500">{{ $post->author->headline }}</p>
            @endif

        </div>

        <div>
            <p class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
            <div class="flex justify-end gap-3">
                @if ($isOwner)
                    {{-- edit --}}
                    <a href="{{ route('perusahaan.post.edit', $post->id) }}"
                        class="inline-flex items-center justify-center rounded-lg transition-colors duration-200" wire:navigate>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                        </svg>
                    </a>

                    {{-- delete --}}
                    <button wire:click="deletePost({{ $post->id }})"
                        class="inline-flex items-center justify-center rounded-lg transition-colors duration-200"
                        onclick="return confirm('Anda yakin menghapus postingan ini?')">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M9 3V4H4V6H5V19C5 20.1 5.9 21 7 21H17C18.1 21 19 20.1 19 19V6H20V4H15V3H9ZM7 6H17V19H7V6ZM9 8V17H11V8H9ZM13 8V17H15V8H13Z" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>
        
    </div>

    <!-- Post Content -->
    <div class="p-4">
        <div class="prose prose-sm max-w-none">
            <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $post->konten }}</p>
        </div>
    </div>

    <!-- Post Images -->
    @if($post->gambarPost->count() > 0)
        <div class="px-4 pb-4">
            @if($post->gambarPost->count() === 1)
                <!-- Single Image -->
                <div class="rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $post->gambarPost->first()->url) }}" alt="Post image"
                        class="w-full h-auto max-h-96 object-cover">
                </div>
            @else
                <!-- Multiple Images Grid -->
                <div
                    class="grid gap-2 rounded-lg overflow-hidden {{ $post->gambarPost->count() === 2 ? 'grid-cols-2' : ($post->gambarPost->count() === 3 ? 'grid-cols-2' : 'grid-cols-2') }}">
                    @foreach($post->gambarPost as $index => $gambar)
                        @if($post->gambarPost->count() === 3 && $index === 0)
                            <div class="col-span-2">
                                <img src="{{ asset('storage/' . $gambar->url) }}" alt="Post image" class="w-full h-48 object-cover">
                            </div>
                        @elseif($post->gambarPost->count() > 4 && $index === 3)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $gambar->url) }}" alt="Post image" class="w-full h-32 object-cover">
                                @if($post->gambarPost->count() > 4)
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                        <span class="text-white text-lg font-semibold">+{{ $post->gambarPost->count() - 4 }}</span>
                                    </div>
                                @endif
                            </div>
                            @break
                        @else
                            <img src="{{ asset('storage/' . $gambar->url) }}" alt="Post image"
                                class="w-full {{ $post->gambarPost->count() === 3 && $index > 0 ? 'h-24' : 'h-32' }} object-cover">
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <!-- Engagement Summary -->
    <div class="my-6 mx-4 pt-4 border-t flex gap-4 border-gray-100">
        <div class="flex items-center space-x-2">
            <div class="flex items-center text-red-500">
                <button wire:click="toggleLike">
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

    <!-- Comment Input -->
    @auth
        <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
            <form wire:submit.prevent="addComment" class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    @if(Auth::user()->foto_profil)
                        <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->foto_profil) }}"
                            alt="{{ Auth::user()->name }}">
                    @else
                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-gray-600 text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <textarea wire:model="newComment" id="comment-input" placeholder="Write a comment..." rows="2"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
                    @error('newComment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div class="mt-2 flex justify-end">
                        <button type="submit"
                            class="px-4 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 disabled:opacity-50">
                            Post Comment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @else
        <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
            <p class="text-center text-gray-600">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a> to like and comment
            </p>
        </div>
    @endauth

    <!-- Comments List -->
    @if($post->komentar->count() > 0)
        <div class="border-t border-gray-200 max-h-96 overflow-y-auto">
            @foreach($post->komentar->sortByDesc('created_at') as $comment)
                <div class="px-4 py-3 border-b border-gray-100 last:border-b-0">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            @if($comment->user->foto_profil)
                                <img class="h-8 w-8 rounded-full object-cover"
                                    src="{{ asset('storage/' . $comment->user->foto_profil) }}" alt="{{ $comment->user->name }}">
                            @else
                                <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-gray-600 text-sm font-medium">{{ substr($comment->user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="bg-gray-100 rounded-lg px-3 py-2">
                                <a href="{{ route('pengguna', $comment->user->id) }}" wire:navigate
                                    class="text-sm font-semibold text-gray-900">{{ $comment->user->name }}</a>
                                <p class="text-sm text-gray-800 mt-1 whitespace-pre-wrap">{{ $comment->konten }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>