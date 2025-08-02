<?php

namespace App\Livewire\Pengalaman;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Perusahaan;
use App\Models\Pengalaman;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
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
    public $pengalaman;

    public function mount($pengalamanId)
    {
        $this->pengalaman = Pengalaman::find($pengalamanId);

        if (!$this->pengalaman) abort(404, 'Pengalaman tidak ditemukan.');

        if (Auth::user()->id !== $this->pengalaman->user_id) abort(403, 'Kamu tidak memiliki hak akses untuk mengedit pengalaman ini.');

        $this->namaPerusahaan = $this->pengalaman->nama_perusahaan;
        $this->jabatan = $this->pengalaman->jabatan;
        $this->tipePekerjaan = $this->pengalaman->tipe_pekerjaan;
        $this->tanggalMulai = $this->pengalaman->tanggal_mulai;
        $this->tanggalSelesai = $this->pengalaman->tanggal_selesai;
        $this->deskripsi = $this->pengalaman->deskripsi;
        $this->lokasi = $this->pengalaman->lokasi;

        $this->perusahaans = Perusahaan::get();
    }    

    public function update(){
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

        $this->pengalaman->update([
            'nama_perusahaan' => $validated['namaPerusahaan'],
            'jabatan' => $validated['jabatan'],
            'tipe_pekerjaan' => $validated['tipePekerjaan'],
            'tanggal_mulai' => $validated['tanggalMulai'],
            'tanggal_selesai' => $validated['tanggalSelesai'],
            'deskripsi' => $validated['deskripsi'],
            'lokasi' => $validated['lokasi'],
            'user_id' => Auth::user()->id,
        ]);

        session()->flash('success', 'Pengalaman berhasil diupdate.');
        return $this->redirect(route('profile'), navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pengalaman.edit');
    }
}