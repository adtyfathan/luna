<?php

namespace App\Livewire\Perusahaan;

use App\Models\FollowerPerusahaan;
use App\Models\Perusahaan;
use App\Models\Post;
use App\Models\Produk;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Jabatan;
use App\Models\Like;

class PerusahaanIndex extends Component
{
    public $activeTab = 'home'; // home || posts || products
    public $perusahaan;
    public $products;
    public $posts;
    public $isOwner;
    public $isFollowing = false;
    public $showFollowersModal = false;
    public $followerCount;
    public function mount($perusahaanId)
    {
        $this->perusahaan = Perusahaan::with([
            'provinsi',
            'kota',
            'followerPerusahaan',
            'produk'
        ])->withCount([
            'followerPerusahaan as followerCount'
        ])->find($perusahaanId);

        if (!$this->perusahaan) abort(404, "Company not found");

        $this->isFollowing = FollowerPerusahaan::where('perusahaan_id', $perusahaanId)
            ->where('follower_id', Auth::user()->id)
            ->exists();

        $this->posts = Post::with([
            'gambarPost',
            'like',
            'komentar'
        ])->where('author_id', $this->perusahaan->id)
        ->orderBy('created_at', 'desc')
        ->get();

        $this->isOwner = Jabatan::where('user_id', Auth::user()->id)
            ->where('perusahaan_id', $perusahaanId)
            ->where('status_id', 3)
            ->exists();

        $this->followerCount = $this->perusahaan->followerCount;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function toggleFollow(){
        if($this->isFollowing){
            FollowerPerusahaan::where('perusahaan_id', $this->perusahaan->id)
                ->where('follower_id', Auth::user()->id)
                ->delete();
            $this->isFollowing = false;
            $this->followerCount -= 1;
        } else {
            FollowerPerusahaan::create([
                'perusahaan_id' => $this->perusahaan->id,
                'follower_id' => Auth::user()->id
            ]);
            $this->isFollowing = true;
            $this->followerCount += 1;
        }
    }

    public function showFollowers()
    {
        $this->showFollowersModal = true;
    }

    public function closeModals()
    {
        $this->showFollowersModal = false;
    }

    public function toggleLike($postId)
    {
        $like = Like::where('post_id', $postId)
            ->where('user_id', Auth::id())
            ->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'post_id' => $postId,
                'user_id' => Auth::id(),
            ]);
        }
    }

    public function deletePost($postId){
        Post::find($postId)->delete();

        session()->flash('success', 'Post berhasil dihapus.');
        return $this->redirect(route('perusahaan.index', $this->perusahaan->id), navigate: true);
    }

    public function redirectToPost($postId){
        return $this->redirect(route('perusahaan.post.show', $postId), true);
    }


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.perusahaan.perusahaan-index');
    }
}
