<?php

namespace App\Livewire\Perusahaan\Post;

use Livewire\Component;
use App\Models\Post;
use App\Models\Like;
use App\Models\Komentar;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use App\Models\Jabatan;

class Show extends Component
{
    public Post $post;
    public $newComment = '';
    public $isLiked = false;
    public $likesCount = 0;
    public $commentsCount = 0;
    public $isOwner;

    public function mount($postId)
    {
        $this->post = Post::with(['author', 'gambarPost', 'like.user', 'komentar.user'])
            ->findOrFail($postId);

        $this->isOwner = Jabatan::where('user_id', Auth::user()->id)
            ->where('perusahaan_id', $this->post->author_id)
            ->where('status_id', 3)
            ->exists();

        $this->checkIfLiked();
        $this->updateCounts();
    }

    public function toggleLike()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $existingLike = Like::where('post_id', $this->post->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $this->isLiked = false;
        } else {
            Like::create([
                'post_id' => $this->post->id,
                'user_id' => Auth::id(),
            ]);
            $this->isLiked = true;
        }

        $this->updateCounts();
    }

    public function addComment()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate([
            'newComment' => 'required|string|max:1000',
        ]);

        Komentar::create([
            'konten' => $this->newComment,
            'post_id' => $this->post->id,
            'user_id' => Auth::id(),
        ]);

        $this->newComment = '';
        $this->post->refresh();
        $this->updateCounts();
    }

    private function checkIfLiked()
    {
        if (Auth::check()) {
            $this->isLiked = Like::where('post_id', $this->post->id)
                ->where('user_id', Auth::id())
                ->exists();
        }
    }

    private function updateCounts()
    {
        $this->likesCount = $this->post->like()->count();
        $this->commentsCount = $this->post->komentar()->count();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.perusahaan.post.show');
    }
}
