<?php

namespace App\Livewire;

use App\Models\Edukasi as ModelsEdukasi;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class Edukasi extends Component
{
    use WithPagination;
    public function mount()
    {
        
    }
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.edukasi.edukasi', [
            'edukasis' => ModelsEdukasi::paginate(9)->sortBy([
                'created_at']),
        ]);
    }
}
