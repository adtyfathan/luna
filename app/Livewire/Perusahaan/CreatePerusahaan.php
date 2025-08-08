<?php

namespace App\Livewire\Perusahaan;

use App\Models\Kota;
use App\Models\Perusahaan;
use App\Models\Provinsi;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;

class CreatePerusahaan extends Component
{
    use WithFileUploads;

    public $nama_perusahaan;
    public $headline;
    public $keterangan;
    public $kota;
    public $provinsi;
    public $logo;

    public $provinsis;
    public $kotas;

    public function mount(){
        $this->kotas = Kota::get();
        $this->provinsis = Provinsi::get();
    }

    protected $rules = [
        'nama_perusahaan' => 'required|string|max:255',
        'headline' => 'nullable|string|max:255',
        'keterangan' => 'nullable|string',
        'kota' => 'nullable|exists:kota,id',
        'provinsi' => 'nullable|exists:provinsi,id',
        'logo' => 'nullable|image',
    ];

    protected $messages = [
        'nama_perusahaan.required' => 'Nama UMKM wajib diisi.',
        'nama_perusahaan.max' => 'Nama UMKM maksimal 255 karakter.',
    ];

    public function createCompany()
    {
        $this->validate();

        $perusahaan = Perusahaan::create([
            'nama_perusahaan' => $this->nama_perusahaan,
            'headline' => $this->headline,
            'keterangan' => $this->keterangan,
            'provinsi_id' => $this->provinsi,
            'kota_id' => $this->kota,
        ]);

        $path = $this->logo->store('company-logo', 'public');
        $perusahaan->logo = $path;

        $perusahaan->save();

        Jabatan::create([
            'user_id' => Auth::user()->id,
            'perusahaan_id' => $perusahaan->id,
            'status_id' => 3
        ]);

        session()->flash('message', 'UMKM berhasil dibuat! Selamat datang di platform kami.');
        return $this->redirect(route('perusahaan.index', $perusahaan->id), true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.perusahaan.create-perusahaan');
    }
}
