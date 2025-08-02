<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class Pengguna extends Component
{
    public $user;
    public $followers;
    public $activeTab = 'profil';
    public $isFollowing = false;
    public $showFollowersModal = false;
    public $showFollowingModal = false;

    public function mount($userId)
    {
        $this->user = User::with(
            'provinsi',
            'kota',
            'follower',
            'following',
            'followerPerusahaan',
            'pengalaman.perusahaan',
            'pendidikan.institusiPendidikan',

        )
            ->withCount([
                'follower as followerCount',
                'following as followingCount'
            ])
            ->find($userId);

        if (!$this->user)
            abort(404, 'User tidak ditemukan.');

        // Check if current user is following this user
        if (Auth::check()) {
            $this->isFollowing = Auth::user()->following()->where('following_id', $userId)->exists();
        }
    }

    public function getJobTypeLabel($type)
    {
        return match ($type) {
            'penuh_waktu' => 'Penuh Waktu',
            'paruh_waktu' => 'Paruh Waktu',
            'kontrak' => 'Kontrak',
            'magang' => 'Magang',
            default => ucfirst($type)
        };
    }

    public function getJobTypeBadgeColor($type)
    {
        return match ($type) {
            'penuh_waktu' => 'bg-green-100 text-green-800',
            'paruh_waktu' => 'bg-blue-100 text-blue-800',
            'kontrak' => 'bg-orange-100 text-orange-800',
            'magang' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function formatDate($date)
    {
        return $date ? \Carbon\Carbon::parse($date)->format('M Y') : 'Present';
    }

    public function calculateDuration($start, $end)
    {
        $startDate = \Carbon\Carbon::parse($start);
        $endDate = $end ? \Carbon\Carbon::parse($end) : \Carbon\Carbon::now();

        $diff = $startDate->diff($endDate);

        $years = $diff->y;
        $months = $diff->m;

        if ($years > 0 && $months > 0) {
            return "{$years} tahun {$months} bulan";
        } elseif ($years > 0) {
            return "{$years} tahun";
        } elseif ($months > 0) {
            return "{$months} bulan";
        } else {
            return "Kurang dari 1 bulan";
        }
    }

    public function getTingkatBadgeColor($type)
    {
        return match ($type) {
            'SMP' => 'bg-green-100 text-green-800',
            'SMA' => 'bg-blue-100 text-blue-800',
            'D3' => 'bg-orange-100 text-orange-800',
            'S1' => 'bg-yellow-100 text-yellow-800',
            'S2' => 'bg-red-100 text-red-800',
            'S3' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function setActiveTab($tab){
        $this->activeTab = $tab;
    }

    public function toggleFollow()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $currentUser = Auth::user();

        if ($this->isFollowing) {
            $currentUser->following()->detach($this->user->id);
            $this->isFollowing = false;
        } else {
            $currentUser->following()->attach($this->user->id);
            $this->isFollowing = true;
        }
    }

    public function showFollowers()
    {
        $this->showFollowersModal = true;
    }

    public function showFollowing()
    {
        $this->showFollowingModal = true;
    }

    public function closeModals()
    {
        $this->showFollowersModal = false;
        $this->showFollowingModal = false;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pengguna');
    }
}