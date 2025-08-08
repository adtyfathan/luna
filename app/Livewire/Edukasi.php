<?php

namespace App\Livewire;

use App\Models\Edukasi as ModelsEdukasi;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class Edukasi extends Component
{
    public $search = '';

    use WithPagination;
    
    public function mount()
    {
        
    }

    public function search()
    {
        $this->resetPage();
    }
    
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    #[Layout('layouts.app')]
    public function render()
    {
        $edukasis = ModelsEdukasi::where('judul', 'like', '%'.$this->search.'%')
                                ->orderBy('created_at', 'desc')
                                ->paginate(9);
        
        return view('livewire.edukasi.edukasi', [
            'edukasis' => $edukasis,
        ]);
    }
}