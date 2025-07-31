<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengalaman;

new class extends Component {
    public $user;
    public $pengalamans;

    public function mount()
    {
        $this->user = Auth::user();
        $this->pengalamans = Pengalaman::with('perusahaan')
            ->where('user_id', $this->user->id)
            ->orderBy('tanggal_mulai', 'desc')
            ->get();
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

    public function delete($pengalamanId){
        Pengalaman::find($pengalamanId)->delete();

        session()->flash('success', 'Pengalaman berhasil dihapus.');
        return $this->redirect(route('profile'), navigate: true);
    }
}

?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Pengalaman Kerja') }}
        </h2>
    
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Daftar pengalaman kerja anda.') }}
        </p>
    </header>

    <div class="space-y-6 mt-6">

        <div>
            <a href="{{ route('pengalaman.create') }}" class="bg-blue-500 text-white py-2 px-6 text-sm rounded-lg" wire:navigate>Tambah Pengalaman</a>
        </div>

        @forelse($pengalamans as $pengalaman)
            <div class="my-2 p-4 border-b hover:shadow-md rounded-md transition duration-200">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                    <!-- Main Content -->
                    <div class="flex-1">
                        <div class="flex items-start space-x-4">
                            <!-- Company Logo -->
                            <div class="flex-shrink-0 mr-4">
                                @if($pengalaman->perusahaan && $pengalaman->perusahaan->logo)
                                    <img class="w-12 h-12 rounded-lg object-cover border border-gray-200" 
                                            src="{{ Storage::url($pengalaman->perusahaan->logo) }}" 
                                            alt="{{ $pengalaman->perusahaan->nama_perusahaan ?? $pengalaman->nama_perusahaan }}">
                                @else
                                    <img src="{{ asset('images/default-company.png') }}" class="w-12 h-12 rounded-lg flex items-center justify-center shadow-md bg-blue-100" alt="default perusahaan image">         
                                @endif
                            </div>

                            <!-- Job Details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                                    <h3 class="text-xl font-semibold text-gray-900 truncate">
                                        {{ $pengalaman->jabatan }}
                                    </h3>
                                    <div class="mt-2 sm:mt-0 sm:ml-4 flex justify-center items-center gap-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getJobTypeBadgeColor($pengalaman->tipe_pekerjaan) }}">
                                            {{ $this->getJobTypeLabel($pengalaman->tipe_pekerjaan) }}
                                        </span>

                                        {{-- edit --}}
                                        <a href="{{ route('pengalaman.edit', $pengalaman->id) }}"
                                            class="inline-flex items-center justify-center rounded-lg transition-colors duration-200"
                                            wire:navigate>
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                            </svg>
                                        </a>

                                        {{-- delete --}}
                                        <button wire:click="delete({{ $pengalaman->id }})" class="inline-flex items-center justify-center rounded-lg transition-colors duration-200"
                                            onclick="return confirm('Anda yakin menghapus pengalaman ini?')">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M9 3V4H4V6H5V19C5 20.1 5.9 21 7 21H17C18.1 21 19 20.1 19 19V6H20V4H15V3H9ZM7 6H17V19H7V6ZM9 8V17H11V8H9ZM13 8V17H15V8H13Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex items-center text-gray-600 mb-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span class="text-sm font-medium">
                                        {{ $pengalaman->perusahaan->nama_perusahaan ?? $pengalaman->nama_perusahaan }}
                                    </span>
                                </div>

                                <div class="flex flex-col sm:flex-row sm:items-center text-gray-500 text-sm space-y-1 sm:space-y-0 sm:space-x-4 mb-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4M8 7H3a1 1 0 00-1 1v10a1 1 0 001 1h18a1 1 0 001-1V8a1 1 0 00-1-1h-5M8 7v13M16 7v13"></path>
                                        </svg>
                                        {{ $this->formatDate($pengalaman->tanggal_mulai) }} - {{ $pengalaman->tanggal_selesai ? $this->formatDate($pengalaman->tanggal_selesai) : 'Sekarang' }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        @if ($pengalaman->tanggal_mulai && $pengalaman->tanggal_selesai)
                                            {{ $this->calculateDuration($pengalaman->tanggal_mulai, $pengalaman->tanggal_selesai) }}
                                        @endif
                                    </div>
                                </div>

                                @if($pengalaman->lokasi)
                                    <div class="flex items-center text-gray-500 text-sm mb-3">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $pengalaman->lokasi }}
                                    </div>
                                @endif

                                @if($pengalaman->deskripsi)
                                    <div class="prose prose-sm max-w-none text-gray-700">
                                        <p>{{ $pengalaman->deskripsi }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
        @endforelse
    </div>

    <!-- Mobile Add Button -->
    <div class="sm:hidden fixed bottom-6 right-6">
        <button class="w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg flex items-center justify-center transition-colors duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
        </button>
    </div>
</section>