<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GalleryGrid extends Component
{
    public array $images;
    public ?string $title;
    public int $columns;

    /**
     * Create a new component instance.
     */
    public function __construct(array $images, ?string $title = null, int $columns = 4)
    {
        $this->images = $images;
        $this->title = $title;
        $this->columns = min(max($columns, 2), 6); // Ensure columns between 2-6
    }

    /**
     * Get Bootstrap column class based on columns
     */
    public function getColumnClass(): string
    {
        return match($this->columns) {
            2 => 'col-lg-6 col-md-6',
            3 => 'col-lg-4 col-md-6',
            4 => 'col-lg-3 col-md-4 col-sm-6',
            6 => 'col-lg-2 col-md-3 col-sm-4',
            default => 'col-lg-3 col-md-4 col-sm-6',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.gallery-grid');
    }
}
