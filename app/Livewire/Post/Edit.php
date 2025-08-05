<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Edit extends Component
{

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post.edit');
    }
}
