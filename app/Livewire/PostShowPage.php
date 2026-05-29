<?php

namespace App\Livewire;

use App\Models\Post;
use App\Support\PracticeTracker;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.home')]
class PostShowPage extends Component
{
    public Post $post;

    public function mount(Post $post): void
    {
        if (! $post->isPublished()) {
            abort(404);
        }

        app(PracticeTracker::class)->logActivity('post_view', $post, [
            'title' => $post->title,
        ]);
    }

    public function render()
    {
        return view('livewire.post-show-page', [
            'heroImage' => $this->post->resolvedImageUrl(),
        ])->title($this->post->title.' — Kinh Học Phật Giáo');
    }
}
