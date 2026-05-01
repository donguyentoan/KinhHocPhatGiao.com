<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.home')]
class IntroductionPage extends Component
{
    public function render()
    {
        return view('livewire.introduction-page');
    }
}
