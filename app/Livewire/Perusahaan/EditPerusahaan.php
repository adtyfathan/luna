<?php

namespace App\Livewire\Perusahaan;

use Livewire\Component;
use Livewire\Attributes\Layout;

class EditPerusahaan extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.perusahaan.edit-perusahaan');
    }
}
