<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($cards as $index => $card)
                <div class="{{ $getColumnClass() }} wow fadeInUp" data-wow-delay="{{ ($index * 0.2) + 0.1 }}s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            @if(isset($card['icon']))
                                <i class="{{ $card['icon'] }} fa-3x text-primary mb-4"></i>
                            @elseif(isset($card['image']))
                                <img class="img-fluid" src="{{ $card['image'] }}" alt="{{ $card['title'] ?? '' }}" loading="lazy">
                            @endif
                            
                            @if(isset($card['title']))
                                <h5 class="mb-3">{{ $card['title'] }}</h5>
                            @endif
                            
                            @if(isset($card['description']))
                                <p>{{ $card['description'] }}</p>
                            @endif
                            
                            @if(isset($card['link']))
                                <a class="btn btn-square btn-primary rounded-circle mt-3" href="{{ $card['link'] }}">
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
