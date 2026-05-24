<?php

namespace App\Livewire;

use App\Models\VegetarianRecipe;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.home')]
class RecipeListPage extends Component
{
    public function render()
    {
        return view('livewire.recipe-list-page', [
            'recipes' => VegetarianRecipe::query()->published()->ordered()->get(),
            'featured' => VegetarianRecipe::query()->published()->where('is_featured', true)->ordered()->take(3)->get(),
        ])->title('Món chay thanh đạm — Kinh Học Phật Giáo');
    }
}
