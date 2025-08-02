<?php

namespace App\Livewire\Pendidikan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\InstitusiPendidikan;
use App\Models\Pendidikan;

class Edit extends Component
{
    public $instansis;
    public $pendidikan;

    // form
    public $namaInstitusi;
    public $tingkat;
    public $jurusan;
    public $tanggalMulai;
    public $tanggalSelesai;
    public $ipk;
    public $deskripsi;
    public $institusiId;

    public function mount($pendidikanId)
    {
        $this->pendidikan = Pendidikan::find($pendidikanId);

        if (!$this->pendidikan) abort(404, 'Pendidikan tidak ditemukan.');

        if (Auth::user()->id !== $this->pendidikan->user_id) abort(403, 'Kamu tidak memiliki hak akses untuk mengedit pendidikan ini.');

        $this->namaInstitusi = $this->pendidikan->nama_institusi;
        $this->tingkat = $this->pendidikan->tingkat;
        $this->jurusan = $this->pendidikan->jurusan;
        $this->ipk = $this->pendidikan->ipk;
        $this->institusiId = $this->pendidikan->institusi_pendidikan_id;
        $this->tanggalMulai = $this->pendidikan->tanggal_mulai;
        $this->tanggalSelesai = $this->pendidikan->tanggal_selesai;
        $this->deskripsi = $this->pendidikan->deskripsi;

        $this->instansis = InstitusiPendidikan::get();
    }

    public function update(){
        $validated = $this->validate([
            'namaInstitusi' => 'nullable|string|max:255',
            'tingkat' => 'required|in:SMP,SMA,D3,S1,S2,S3',
            'jurusan' => 'nullable|string|max:255',
            'tanggalMulai' => 'required|date',
            'tanggalSelesai' => 'nullable|date',
            'ipk' => 'nullable|numeric|min:0|max:4',
            'deskripsi' => 'nullable|string',
            'institusiId' => 'nullable|exists:institusi_pendidikan,id'
        ]);

        $this->pendidikan->update([
            'nama_institusi' => $validated['namaInstitusi'],
            'tingkat' => $validated['tingkat'],
            'jurusan' => $validated['jurusan'],
            'tanggal_mulai' => $validated['tanggalMulai'],
            'tanggal_selesai' => $validated['tanggalSelesai'],
            'ipk' => $validated['ipk'],
            'deskripsi' => $validated['deskripsi'],
            'institusi_pendidikan_id' => $validated['institusiId']
        ]);

        session()->flash('success', 'Pendidikan berhasil diupdate.');
        return $this->redirect(route('profile'), navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pendidikan.edit');
    }
}
