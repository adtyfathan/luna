<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\User;
use App\Models\Perusahaan;

class Beranda extends Component
{
    public $posts = [];
    public $perusahaanUser = [];
    public $user;

    public function mount(){
        $this->posts = Post::with([
            'gambarPost',
            'like',
            'komentar',
        ])->orderBy('created_at', 'desc')
        ->get();

        if(Auth::user()) {
            $userId = Auth::user()->id;

            $this->user = User::with([
                'provinsi',
                'kota',
            ])->find($userId);

            $this->perusahaanUser = Perusahaan::whereHas('jabatan', function ($query) use ($userId) {
                $query->where('status_id', 3)
                    ->where('user_id', $userId);
            })->get();
        }
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

    public function redirectToPost($postId, $type){
        if($type === 'AppModelsUser'){
            return $this->redirect(route('post.show', $postId), navigate: true);
        } else if ($type === 'AppModelsPerusahaan'){
            return $this->redirect(route('perusahaan.post.show', $postId), navigate: true);
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.beranda');
    }
}