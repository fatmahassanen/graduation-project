<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class VideoSection extends Component
{
    public string $videoUrl;
    public ?string $title;
    public ?string $description;
    public bool $autoplay;
    public bool $controls;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $videoUrl,
        ?string $title = null,
        ?string $description = null,
        bool $autoplay = true,
        bool $controls = true
    ) {
        $this->videoUrl = $videoUrl;
        $this->title = $title;
        $this->description = $description;
        $this->autoplay = $autoplay;
        $this->controls = $controls;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.video-section');
    }
}
