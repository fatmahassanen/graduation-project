<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class CardGrid extends Component
{
    public array $cards;
    public int $columns;

    /**
     * Create a new component instance.
     */
    public function __construct(array $cards, int $columns = 3)
    {
        $this->cards = $cards;
        $this->columns = min(max($columns, 1), 4); // Ensure columns between 1-4
    }

    /**
     * Get Bootstrap column class based on columns
     */
    public function getColumnClass(): string
    {
        return match($this->columns) {
            1 => 'col-12',
            2 => 'col-lg-6 col-md-6',
            3 => 'col-lg-4 col-md-6',
            4 => 'col-lg-3 col-md-6',
            default => 'col-lg-4 col-md-6',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.card-grid');
    }
}
