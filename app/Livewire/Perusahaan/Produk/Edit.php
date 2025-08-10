<?php

namespace App\Livewire\Perusahaan\Produk;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    public $produkId;
    public $namaProduk = '';
    public $deskripsiProduk = '';
    public $fotoLama;
    public $gambar;
    public $hargaProduk = '';
    public $kategoriProduk = '';

    public function mount($produkId)
    {
        $produk = Produk::find($produkId);
        if (!$produk) {
            abort(404, "Product not found");
        }

        if ($produk->gambar_produk && Storage::disk('public')->exists($produk->gambar_produk)) {
            $this->gambar = Storage::url($produk->gambar_produk);
            $this->fotoLama = Storage::url($produk->gambar_produk);
        }

        $kategori = Kategori::find($produk->kategori_id);

        $this->namaProduk = $produk->nama_produk;
        $this->deskripsiProduk = $produk->deskripsi;
        $this->hargaProduk = $produk->harga;
        $this->kategoriProduk = $kategori->nama_kategori;
    }

    public function update()
    {
        $this->validate([
            'namaProduk' => 'required|string|max:255',
            'deskripsiProduk' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
            'hargaProduk' => 'required|numeric|min:0',
            'kategoriProduk' => 'required|string|max:255',
        ]);

        $produk = Produk::find($this->produkId);
        if (!$produk) {
            abort(404, "Product not found");
        }

        if ($this->gambar && $this->gambar != $this->fotoLama) {
            if (Storage::disk('public')->exists($produk->gambar_produk)) {
                Storage::disk('public')->delete($produk->gambar_produk);
            }

            $path = $this->gambar->store('images', 'public');
            $produk->gambar_produk = $path;
        }

        $kategori = Kategori::firstOrCreate(['nama_kategori' => $this->kategoriProduk]);

        $produk->update([
            'nama_produk' => $this->namaProduk,
            'deskripsi' => $this->deskripsiProduk,
            'gambar_produk' => $produk->gambar_produk,
            'harga' => $this->hargaProduk,
            'kategori_id' => $kategori->id,
        ]);

        session()->flash('message', 'Produk berhasil diperbarui!');
        
        return redirect()->route('perusahaan.index', ['perusahaanId' => $produk->perusahaan_id]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.perusahaan.produk.edit');
    }
}
