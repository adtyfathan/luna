<?php

namespace App\Livewire\Perusahaan;

use App\Models\Jabatan;
use App\Models\Kota;
use App\Models\Perusahaan;
use App\Models\Provinsi;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditPerusahaan extends Component
{
    use WithFileUploads;
    public $perusahaan;
    public $nama_perusahaan;
    public $headline;
    public $keterangan;
    public $kota;
    public $provinsi;
    public $logo;

    public $provinsis;
    public $kotas;

    public function mount($perusahaanId){
        $this->perusahaan = Perusahaan::find($perusahaanId);

        if(!$this->perusahaan) abort(404, "Company not found.");

        $isOwner = Jabatan::where('user_id', Auth::user()->id)
            ->where('perusahaan_id', $perusahaanId)
            ->where('status_id', 3)
            ->exists();

        if(!$isOwner) abort(403, "Unauthorized.");

        $this->nama_perusahaan = $this->perusahaan->nama_perusahaan;
        $this->headline = $this->perusahaan->headline;
        $this->keterangan = $this->perusahaan->keterangan;
        $this->logo = $this->perusahaan->logo;
        $this->provinsi = $this->perusahaan->provinsi_id;
        $this->kota = $this->perusahaan->kota_id;

        $this->provinsis = Provinsi::get();
        $this->kotas = Kota::get();
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

    public function editCompany(){
        $this->validate();

        $this->perusahaan->update([
            'nama_perusahaan' => $this->nama_perusahaan,
            'headline' => $this->headline,
            'keterangan' => $this->keterangan,
            'provinsi_id' => $this->provinsi,
            'kota_id' => $this->kota,
        ]);

        if($this->logo){
            if(Storage::disk('public')->exists($this->logo)){
                Storage::disk('public')->delete($this->logo);
            }

            $path = $this->logo->store('company-logo', 'public');
            $this->perusahaan->logo = $path;
        }

        $this->perusahaan->save();

        session()->flash('message', 'UMKM berhasil diedit! Selamat datang di platform kami.');
        return $this->redirect(route('perusahaan.index', $this->perusahaan->id), true);
    }


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.perusahaan.edit-perusahaan');
    }
}
