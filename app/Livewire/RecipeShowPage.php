<?php

namespace App\Livewire;

use App\Models\VegetarianRecipe;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.home')]
class RecipeShowPage extends Component
{
    public VegetarianRecipe $recipe;

    public function mount(VegetarianRecipe $recipe): void
    {
        if (! $recipe->isPublished()) {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.recipe-show-page', [
            'heroImage' => $this->recipe->resolvedImageUrl(),
            'related' => VegetarianRecipe::query()
                ->published()
                ->whereKeyNot($this->recipe->id)
                ->ordered()
                ->take(3)
                ->get(),
        ])->title($this->recipe->title.' — Món chay thanh đạm');
    }
}
