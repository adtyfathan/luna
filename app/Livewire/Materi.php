<?php

namespace App\Livewire;

use App\Models\Edukasi;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

class Materi extends Component
{
    use WithPagination;
    public $materiId;
    public $materi;
    public function mount()
    {
        $this->materi = Edukasi::findOrFail($this->materiId);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.edukasi.materi', [
            'recomends' => Edukasi::paginate(5)->whereNotIn('id', $this->materiId)->sortBy([
                'created_at']),
        ]);
    }
}
