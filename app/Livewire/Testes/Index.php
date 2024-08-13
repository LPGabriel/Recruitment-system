<?php

namespace App\Livewire\Testes;

use App\Models\Quiz;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public Quiz $quiz;

    public function mount($slug)
    {
        $this->quiz = Quiz::where('slug', $slug)->first();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.testes.index');
    }
}
