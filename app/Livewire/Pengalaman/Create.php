<?php

namespace App\Livewire\Pengalaman;

use App\Models\Pengalaman;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $perusahaans;

    // form
    public $namaPerusahaan;
    public $jabatan;
    public $tipePekerjaan;
    public $tanggalMulai;
    public $tanggalSelesai;
    public $deskripsi;
    public $lokasi;
    public $perusahaanId;
    
    public function mount()
    {
        $this->perusahaans = Perusahaan::get();
    }    

    public function store(){
        $validated = $this->validate([
            'namaPerusahaan' => 'nullable|string|max:255',
            'jabatan' => 'required|string|max:255',
            'tipePekerjaan' => 'required|in:penuh_waktu,paruh_waktu,kontrak,magang',
            'tanggalMulai' => 'required|date',
            'tanggalSelesai' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'perusahaanId' => 'nullable|exists:perusahaan,id'
        ]);

        Pengalaman::create([
            'nama_perusahaan' => $validated['namaPerusahaan'],
            'jabatan' => $validated['jabatan'],
            'tipe_pekerjaan' => $validated['tipePekerjaan'],
            'tanggal_mulai' => $validated['tanggalMulai'],
            'tanggal_selesai' => $validated['tanggalSelesai'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi' => $validated['lokasi'],
            'user_id' => Auth::user()->id,
        ]);

        session()->flash('success', 'Pengalaman berhasil ditambahkan.');
        return $this->redirect(route('profile'), navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pengalaman.create');
    }
}