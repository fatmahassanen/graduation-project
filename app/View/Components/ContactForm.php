<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ContactForm extends Component
{
    public ?string $title;
    public ?string $description;
    public array $contactInfo;
    public ?string $mapUrl;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $title = null,
        ?string $description = null,
        array $contactInfo = [],
        ?string $mapUrl = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->contactInfo = $contactInfo;
        $this->mapUrl = $mapUrl;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.contact-form');
    }
}
