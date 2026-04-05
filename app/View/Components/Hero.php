<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Hero extends Component
{
    public string $title;
    public string $description;
    public ?string $image;
    public ?string $ctaText;
    public ?string $ctaLink;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $title,
        string $description = '',
        ?string $image = null,
        ?string $ctaText = null,
        ?string $ctaLink = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->ctaText = $ctaText;
        $this->ctaLink = $ctaLink;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.hero');
    }
}
