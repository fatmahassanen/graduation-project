@extends('layouts.app')

@section('content')
    {{-- Translation unavailable message --}}
    @if(isset($translationUnavailable) && $translationUnavailable)
        <div class="container-xxl py-3">
            <div class="container">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Translation Not Available:</strong> 
                    This page is not available in {{ $requestedLanguage === 'ar' ? 'Arabic' : 'the requested language' }}. 
                    Showing the English version instead.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    {{-- If page has content blocks, render them --}}
    @if($page->contentBlocks->count() > 0)
        @foreach($page->contentBlocks as $block)
            @if($block->type === 'html')
                {{-- Render raw HTML content --}}
                {!! $block->content['html'] ?? '' !!}
            @else
                {{-- Render other block types --}}
                @switch($block->type)
                    @case('hero')
                        <x-hero 
                            :title="$block->content['title'] ?? ''"
                            :description="$block->content['description'] ?? ''"
                            :image="$block->content['image'] ?? ''"
                            :ctaText="$block->content['ctaText'] ?? null"
                            :ctaLink="$block->content['ctaLink'] ?? null"
                        />
                        @break

                    @case('text')
                        <div class="container-xxl py-5">
                            <div class="container">
                                {!! $block->content['body'] ?? '' !!}
                            </div>
                        </div>
                        @break

                    @case('card_grid')
                        <x-card-grid 
                            :cards="$block->content['cards'] ?? []"
                            :columns="$block->content['columns'] ?? 3"
                        />
                        @break

                    @case('video')
                        <x-video-section 
                            :videoUrl="$block->content['videoUrl'] ?? ''"
                            :title="$block->content['title'] ?? ''"
                            :description="$block->content['description'] ?? ''"
                        />
                        @break

                    @case('faq')
                        <x-faq-section 
                            :items="$block->content['items'] ?? []"
                        />
                        @break

                    @case('testimonial')
                        <x-testimonial-carousel 
                            :testimonials="$block->content['testimonials'] ?? []"
                        />
                        @break

                    @case('gallery')
                        <x-gallery-grid 
                            :images="$block->content['images'] ?? []"
                        />
                        @break

                    @case('contact_form')
                        <x-contact-form />
                        @break
                @endswitch
            @endif
        @endforeach
    @else
        {{-- No content blocks - show placeholder --}}
        <div class="container-xxl py-5">
            <div class="container text-center">
                <h3>This page has no content yet.</h3>
                <p>Please add content through the admin panel.</p>
            </div>
        </div>
    @endif
@endsection
