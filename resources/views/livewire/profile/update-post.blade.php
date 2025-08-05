<?php

use Livewire\Volt\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $posts;

    public function mount()
    {
        $this->posts = Post::with(
            'author',
            'gambarPost',
            'like',
            'komentar'
        )
        ->where('author_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->get();
    }
}

?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Postingan') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Daftar postingan anda.') }}
        </p>
    </header>

    <div class="space-y-6 mt-6">

        <div>
            <a href="{{ route('post.create') }}"
                class="bg-blue-500 text-white py-2 px-6 text-sm rounded-lg font-semibold" wire:navigate>Tambah
                Post</a>
        </div>
    </div>
</section>
