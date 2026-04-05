<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class TestimonialCarousel extends Component
{
    public array $testimonials;
    public ?string $title;

    /**
     * Create a new component instance.
     */
    public function __construct(array $testimonials, ?string $title = null)
    {
        $this->testimonials = $testimonials;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.testimonial-carousel');
    }
}
