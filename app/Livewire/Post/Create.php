<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Create extends Component
{

    public function mount(){
        
    }


    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post.create');
    }
}
