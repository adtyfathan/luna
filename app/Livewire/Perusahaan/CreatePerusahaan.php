<?php

namespace App\Livewire\Perusahaan;

use App\Models\Kota;
use App\Models\Perusahaan;
use App\Models\Provinsi;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

class CreatePerusahaan extends Component
{
    use WithFileUploads;

    public $nama_perusahaan;
    public $keterangan;
    public $kota;
    public $provinsi;
    public $logo;

    protected $rules = [
        'nama_perusahaan' => 'required|string|max:255',
        'keterangan' => 'required|string|min:10',
        'kota' => 'required|string|max:255',
        'provinsi' => 'required|string|max:255',
        'logo' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'nama_perusahaan.required' => 'Nama UMKM wajib diisi.',
        'nama_perusahaan.max' => 'Nama UMKM maksimal 255 karakter.',
        'keterangan.required' => 'Deskripsi UMKM wajib diisi.',
        'keterangan.min' => 'Deskripsi UMKM minimal 10 karakter.',
        'kota.required' => 'Kota UMKM wajib diisi.',
        'provinsi.required' => 'Provinsi UMKM wajib diisi.',
        'logo.image' => 'File harus berupa gambar.',
        'logo.max' => 'Ukuran gambar maksimal 1MB.',
    ];

    public function createCompany()
    {
        $this->validate();

        $kotas = Kota::where('nama_kota', $this->kota)->first();
        if (!$kotas) {
            Kota::create(['nama_kota' => $this->kota]);
            $kotas = Kota::where('nama_kota', $this->kota)->first();
        }

        $provinsis = Provinsi::where('nama_provinsi', $this->provinsi)->first();
        if (!$provinsis) {
            Provinsi::create(['nama_provinsi' => $this->provinsi]);
            $provinsis = Provinsi::where('nama_provinsi', $this->provinsi)->first();
        }

        $perusahaan = Perusahaan::create([
            'nama_perusahaan' => $this->nama_perusahaan,
            'keterangan' => $this->keterangan,
            'kota_id' => $kotas->id,
            'provinsi_id' => $provinsis->id,
        ]);

        if ($this->logo) {
            $fileName = 'avatar_' . $perusahaan->id . '_' . time() . '.' . $this->avatar->getClientOriginalExtension();
            $path = $this->logo->storeAs('company-photos', $fileName, 'public');
            $perusahaan->update(['logo' => $path]);
        }

        session()->flash('message', 'UMKM berhasil dibuat! Selamat datang di platform kami.');
        return redirect()->route('perusahaan.index', ['perusahaan' => $perusahaan->id]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.perusahaan.create-perusahaan');
    }
}
