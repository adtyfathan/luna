<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;
use App\Models\Perusahaan;

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
        $searchTerm = '%' . $this->search . '%';

        if (empty($this->search)) {
            $results = collect(); // Empty result
        } else {
            // Search users
            $users = User::where('name', 'like', $searchTerm)
                ->orWhere('headline', 'like', $searchTerm)
                ->select('id', 'name as display_name', 'headline', 'foto_profil as image', \DB::raw("'user' as type"))
                ->get();

            // Search companies
            $companies = Perusahaan::where('nama_perusahaan', 'like', $searchTerm)
                ->orWhere('headline', 'like', $searchTerm)
                ->select('id', 'nama_perusahaan as display_name', 'headline', 'logo as image', \DB::raw("'perusahaan' as type"))
                ->get();

            // Merge into one collection
            $results = $users->merge($companies);
        }

        return view('livewire.koneksi', [
            'results' => $results
        ]);
    }

}
