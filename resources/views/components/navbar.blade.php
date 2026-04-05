<style>
    /* Hover effect for dropdown items */
    .dropdown-item:hover {
        background-color: #D08301 !important;
        color: #fff !important;
        border-radius: 6px;
        transition: 0.3s;
    }

    /* Dropdown headers spacing */
    .dropdown-menu h5 {
        margin-bottom: 12px;
        font-size: 1.1rem;
    }

    /* Optional: add spacing between links */
    .dropdown-links a {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }
</style>

<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <img src="{{ asset('uni/img.png') }}" alt="Logo" style="height:50px;" loading="eager">
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            @foreach($menuItems as $item)
                @if(isset($item['dropdown']))
                    {{-- Dropdown menu --}}
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle {{ $isActive($item) ? 'active' : '' }}" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $item['label'] }}
                        </a>
                        <div class="dropdown-menu fade-down m-0" style="width: {{ $item['slug'] === 'faculties' ? '400px' : ($item['slug'] === 'about' ? '350px' : '270px') }}; left: 0;">
                            @foreach($item['dropdown'] as $child)
                                <a class="dropdown-item {{ $child['slug'] === $currentPage ? 'active' : '' }}" 
                                   href="{{ $child['url'] }}" 
                                   style="color: #1a096e;"
                                   @if(isset($child['external']) && $child['external']) target="_blank" rel="noopener noreferrer" @endif>
                                    {{ $child['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    {{-- Regular link --}}
                    <a href="{{ $item['url'] }}" class="nav-item nav-link {{ $item['slug'] === $currentPage ? 'active' : '' }}">
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach
        </div>

        {{-- Language Switcher --}}
        <div class="nav-item dropdown me-3">
            <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-globe"></i> {{ strtoupper($language) }}
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                @if(Route::has('language.switch'))
                    <a class="dropdown-item {{ $language === 'en' ? 'active' : '' }}" 
                       href="{{ route('language.switch', ['lang' => 'en', 'slug' => $currentPage]) }}">
                        English
                    </a>
                    <a class="dropdown-item {{ $language === 'ar' ? 'active' : '' }}" 
                       href="{{ route('language.switch', ['lang' => 'ar', 'slug' => $currentPage]) }}">
                        العربية
                    </a>
                @else
                    <a class="dropdown-item {{ $language === 'en' ? 'active' : '' }}" 
                       href="{{ url($currentPage . '?language=en') }}">
                        English
                    </a>
                    <a class="dropdown-item {{ $language === 'ar' ? 'active' : '' }}" 
                       href="{{ url($currentPage . '?language=ar') }}">
                        العربية
                    </a>
                @endif
            </div>
        </div>

        {{-- Reader Controls --}}
        <div class="d-flex align-items-center me-3">
            <button style="border:none; outline:none; font-size:14px; padding:4px; width:30px; height:30px;" 
                    onclick="readPage()" class="reader-btn play" title="Read Page">
                🔊
            </button>
            <button style="border:none; outline:none; font-size:14px; padding:4px; width:30px; height:30px;" 
                    onclick="stopReading()" class="reader-btn stop" title="Stop Reading">
                ⏹
            </button>
        </div>
    </div>
</nav>
