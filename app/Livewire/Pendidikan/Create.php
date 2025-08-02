<?php

namespace App\Livewire\Pendidikan;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\InstitusiPendidikan;
use App\Models\Pendidikan;

class Create extends Component
{
    public $instansis;

    // form
    public $namaInstitusi;
    public $tingkat;
    public $jurusan;
    public $tanggalMulai;
    public $tanggalSelesai;
    public $ipk;
    public $deskripsi;
    public $institusiId;

    public function mount(){
        $this->instansis = InstitusiPendidikan::get();
    }

    public function store(){
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

        Pendidikan::create([
            'nama_institusi' => $validated['namaInstitusi'],
            'tingkat' => $validated['tingkat'],
            'jurusan' => $validated['jurusan'],
            'tanggal_mulai' => $validated['tanggalMulai'],
            'tanggal_selesai' => $validated['tanggalSelesai'],
            'ipk' => $validated['ipk'],
            'deskripsi' => $validated['deskripsi'],
            'user_id' => Auth::user()->id,
            'institusi_pendidikan_id' => $validated['institusiId']
        ]);

        session()->flash('success', 'Pendidikan berhasil ditambahkan.');
        return $this->redirect(route('profile'), navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pendidikan.create');
    }
}