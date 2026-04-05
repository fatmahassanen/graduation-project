<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class FaqSection extends Component
{
    public array $items;
    public ?string $title;
    public ?string $image;

    /**
     * Create a new component instance.
     */
    public function __construct(array $items, ?string $title = null, ?string $image = null)
    {
        $this->items = $items;
        $this->title = $title;
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.faq-section');
    }
}
