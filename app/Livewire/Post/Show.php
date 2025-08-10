<?php

namespace App\Livewire\Post;

use Livewire\Component;
use App\Models\Post;
use App\Models\Like;
use App\Models\Komentar;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class Show extends Component
{
    public Post $post;
    public $newComment = '';
    public $isLiked = false;
    public $likesCount = 0;
    public $commentsCount = 0;
    public $isPoster;

    public function mount($postId)
    {
        $this->post = Post::with(['author', 'gambarPost', 'like.user', 'komentar.user'])
            ->findOrFail($postId);

        $this->checkIfLiked();
        $this->updateCounts();

        $this->isPoster = $this->post->author->id === Auth::id();
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

    public function deletePost()
    {
        $this->post->delete();

        return $this->redirect(route('beranda'), true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post.show');
    }
}