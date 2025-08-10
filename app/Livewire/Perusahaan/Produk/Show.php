<?php

namespace App\Livewire\Perusahaan\Produk;

use App\Models\Jabatan;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Show extends Component
{
    public $perusahaanId;
    public $produkId;
    public $namaProduk;
    public $deskripsiProduk;
    public $gambar;
    public $hargaProduk;
    public $kategoriProduk;
    public $updatedAt;
    public $createdAt;
    public $isOwner;
    public function mount($produkId)
    {
        $produk = Produk::find($produkId);
        if (!$produk) {
            abort(404, "Product not found");
        }

        $kategori = Kategori::find($produk->kategori_id);

        $this->namaProduk = $produk->nama_produk;
        $this->deskripsiProduk = $produk->deskripsi;
        $this->gambar = $produk->gambar_produk;
        $this->hargaProduk = $produk->harga;
        $this->kategoriProduk = $kategori->nama_kategori;
        $this->perusahaanId = $produk->perusahaan_id;
        $this->updatedAt = $produk->updated_at;
        $this->createdAt = $produk->created_at;

        $this->isOwner = Jabatan::where('user_id', Auth::user()->id)
            ->where('perusahaan_id', $produk->perusahaan_id)
            ->where('status_id', 3)
            ->exists();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.perusahaan.produk.show');
    }
}
