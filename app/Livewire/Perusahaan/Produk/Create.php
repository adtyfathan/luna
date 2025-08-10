<?php

namespace App\Livewire\Perusahaan\Produk;

use App\Models\Kategori;
use App\Models\Produk;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public $perusahaanId;
    public $namaProduk = '';
    public $deskripsiProduk = '';
    public $gambar;
    public $hargaProduk = '';
    public $kategoriProduk = '';

    protected $rules = [
        'namaProduk' => 'required|string|max:255',
        'deskripsiProduk' => 'required|string',
        'gambar' => 'required|image|max:2048',
        'hargaProduk' => 'required|numeric|min:0',
        'kategoriProduk' => 'required|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        if ($this->gambar) {
            $path = $this->gambar->store('images', 'public');
        }

        $kategori = Kategori::firstOrCreate(['nama_kategori' => $this->kategoriProduk]);
        

        Produk::create([
            'nama_produk' => $this->namaProduk,
            'deskripsi' => $this->deskripsiProduk,
            'gambar_produk' => $path,
            'harga' => $this->hargaProduk,
            'kategori_id' => $kategori->id,
            'perusahaan_id' => $this->perusahaanId,
        ]);

        session()->flash('message', 'Produk berhasil ditambahkan!');
        
        return redirect()->route('perusahaan.index', ['perusahaanId' => $this->perusahaanId]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.perusahaan.produk.create');
    }
}
