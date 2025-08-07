<?php

use Livewire\Volt\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $posts;
    public $showDeleteModal = false;
    public $postToDelete = null;

    public function mount()
    {
        $this->loadPosts();
    }

    public function loadPosts()
    {
        $this->posts = Post::with([
            'gambarPost',
            'like',
            'komentar'
        ])
            ->where('author_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function confirmDelete($postId)
    {
        $this->postToDelete = $postId;
        $this->showDeleteModal = true;
    }

    public function deletePost()
    {
        if ($this->postToDelete) {
            $post = Post::find($this->postToDelete);
            if ($post && $post->author_id === Auth::user()->id) {
                $post->delete();
                $this->loadPosts();
                $this->showDeleteModal = false;
                $this->postToDelete = null;
                session()->flash('message', 'Post berhasil dihapus!');
            }
        }
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->postToDelete = null;
    }
}

?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Postingan') }}
        </h2>
    
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Daftar postingan anda') }}
        </p>
    </header>

    <div class="space-y-6 mt-6">

        <div>
            <a href="{{ route('post.create') }}" class="bg-blue-500 text-white py-2 px-6 text-sm rounded-lg font-semibold"
                wire:navigate>Tambah Postingan</a>
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-700">{{ session('message') }}</p>
                </div>
            </div>
        @endif

        <!-- Posts List -->
        <div class="space-y-4">
            @forelse ($posts as $post)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200">
                    <!-- Post Header -->
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-3">
                                <img src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : asset('images/default-avatar.png') }}" 
                                    alt="Profile" 
                                    class="w-12 h-12 rounded-full object-cover border-2 border-gray-200">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ Auth::user()->name }}</h3>
                                    @if (Auth::user()->headline)
                                        <p class="text-sm text-gray-500">{{ Auth::user()->headline }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions Menu -->
                            <div>
                                <div class="flex items-center justify-center gap-4">
                                    {{-- edit --}}
                                    <a href="{{ route('post.edit', $post->id) }}" class="rounded-lg transition-colors duration-200" wire:navigate>
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                        </svg>
                                    </a>

                                    {{-- delete --}}
                                    <button wire:click="confirmDelete({{ $post->id }})" class="rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M9 3V4H4V6H5V19C5 20.1 5.9 21 7 21H17C18.1 21 19 20.1 19 19V6H20V4H15V3H9ZM7 6H17V19H7V6ZM9 8V17H11V8H9ZM13 8V17H15V8H13Z" />
                                        </svg>
                                    </button>
                                </div>
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
                                            alt="Post image" 
                                            class="w-full max-h-96 object-cover">
                                    </div>
                                @else
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach($post->gambarPost->take(4) as $index => $image)
                                            <div class="relative rounded-lg overflow-hidden {{ $index >= 2 ? 'hidden sm:block' : '' }}">
                                                <img src="{{ asset('storage/' . $image->url) }}" 
                                                    alt="Post image" 
                                                    class="w-full h-48 object-cover">
                                                @if($loop->last && $post->gambarPost->count() > 4)
                                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                                        <span class="text-white font-semibold text-lg">+{{ $post->gambarPost->count() - 3 }}</span>
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
                                    <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z">
                                        </path>
                                    </svg>
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
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada postingan</h3>
                    <p class="text-gray-500 mb-6">Mulai berbagi pemikiran dan pengalaman Anda dengan membuat post pertama.</p>
                    <a href="{{ route('post.create') }}" 
                    wire:navigate
                    class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Post Pertama
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Delete Confirmation Modal -->
        @if($showDeleteModal)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus Postingan</h3>
                            <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus postingan ini? Tindakan ini tidak dapat dibatalkan.</p>
                        </div>
                        <div class="flex space-x-3">
                            <button wire:click="cancelDelete"
                                    class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                Batal
                            </button>
                            <button wire:click="deletePost"
                                    class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 transition-colors duration-200">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

</section>

