<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;

class Koneksi extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 12;
    public $aktivitases;

    public function mount(){
        $this->aktivitases = Follow::with('follower')
            ->where('following_id', Auth::user()->id)
            ->get();
    }

    public function followUser($userId)
    {
        if (!Auth::check()) {
            return;
        }

        $currentUser = Auth::user();

        if ($currentUser->following()->where('following_id', $userId)->exists()) {
            $currentUser->following()->detach($userId);
        } else {
            $currentUser->following()->attach($userId, [
                'created_at' => now(),
            ]);
        }
    }

    public function formatCreatedAt($createdAt)
    {
        $now = now();
        $created = \Carbon\Carbon::parse($createdAt)->locale('id');

        $diffInMinutes = $created->diffInMinutes($now);
        $diffInHours = $created->diffInHours($now);
        $diffInDays = $created->diffInDays($now);

        if ($diffInMinutes < 1) {
            return 'Baru saja';
        } elseif ($diffInMinutes < 60) {
            return (int)$diffInMinutes . ' menit lalu';
        } elseif ($diffInHours < 24) {
            return (int)$diffInHours . ' jam lalu';
        } elseif ($diffInDays < 7) {
            return (int)$diffInDays . ' hari lalu';
        } elseif ($diffInDays < 30) {
            $weeks = floor($diffInDays / 7);
            return (int)$weeks . ' minggu lalu';
        } else {
            return $created->translatedFormat('d F Y');
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        if (empty($this->search)) {
            $users = User::query()->whereRaw('1 = 0')->paginate($this->perPage);
        } else {
            $searchTerm = '%' . $this->search . '%';

            $users = User::where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('headline', 'like', $searchTerm);
            })->paginate($this->perPage);
        }

        return view('livewire.koneksi', [
            'users' => $users
        ]);
    }
}
