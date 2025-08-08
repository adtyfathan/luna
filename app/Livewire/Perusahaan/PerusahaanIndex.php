<?php

namespace App\Livewire\Perusahaan;

use App\Models\Perusahaan;
use App\Models\Post;
use App\Models\Produk;
use Livewire\Component;
use Livewire\Attributes\Layout;

class PerusahaanIndex extends Component
{
    public $activeTab = 'home';
    public $perusahaan;
    public $products;
    public $posts;

    public function mount($perusahaanId)
    {
        // Assuming we're showing the current user's company
        $this->perusahaan = Perusahaan::where('id', $perusahaanId)->with(['provinsi', 'kota'])->first();
        if ($this->perusahaan) {
            $this->products = Produk::where('perusahaan_id', $this->perusahaan->id)->get();
            $this->posts = Post::where('author_id', $this->perusahaan->id)
                ->with(['gambarPost', 'like', 'komentar'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            abort(404, 'Perusahaan not found');
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.perusahaan.perusahaan-index');
    }
}
