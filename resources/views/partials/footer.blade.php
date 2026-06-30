<style>
    .footer-modern {
        background: #0f172a;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: #94a3b8;
        padding: 80px 0 0;
        margin-top: 80px;
    }

    .footer-modern .footer-logo-wrapper {
        max-height: 50px;
        width: auto;
        object-fit: contain;
        margin-bottom: 16px;
        opacity: 0.95;
        display: block;
    }

    .footer-modern .footer-tagline {
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 24px;
        line-height: 1.5;
    }

    .footer-modern .footer-social {
        display: flex;
        gap: 14px;
        margin-top: 8px;
    }

    .footer-modern .footer-social-link {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 1rem;
    }

    .footer-modern .footer-social-link:hover {
        color: #D08301;
        transform: translateY(-2px);
    }

    .footer-modern .footer-heading {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #e2e8f0;
        margin-bottom: 24px;
    }

    .footer-modern .footer-nav-link {
        display: block;
        color: #94a3b8;
        text-decoration: none;
        font-size: 0.9375rem;
        padding: 6px 0;
        transition: all 0.25s ease;
        opacity: 0.85;
    }

    .footer-modern .footer-nav-link:hover {
        color: #D08301;
        opacity: 1;
        padding-left: 4px;
    }

    .footer-modern .footer-copyright {
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        padding: 28px 0;
        margin-top: 60px;
        text-align: center;
    }

    .footer-modern .footer-copyright-text {
        font-size: 0.8125rem;
        color: #64748b;
        margin: 0;
    }

    @media (max-width: 768px) {
        .footer-modern {
            padding: 50px 0 0;
        }

        .footer-modern .footer-social {
            justify-content: flex-start;
        }

        .footer-modern .footer-copyright {
            margin-top: 40px;
        }
    }
</style>

<footer class="footer-modern">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4 col-md-6">
                <img src="{{ asset('img/sub-sub-logo.png') }}" alt="NCTU" class="footer-logo-wrapper">
                <p class="footer-tagline">{{ __('messages.footer_tagline') }}</p>
                <div class="footer-social">
                    <a href="https://www.facebook.com/nctu.edu.eg/?locale=ar_AR" class="footer-social-link" target="_blank" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/explore/locations/113014853445529/new-cairo-technological-university/" class="footer-social-link" target="_blank" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://t.me/+hu88qUXmcXNlNmQ0" class="footer-social-link" target="_blank" aria-label="Telegram">
                        <i class="fab fa-telegram-plane"></i>
                    </a>
                    <a href="https://www.linkedin.com/school/nct-uni/" class="footer-social-link" target="_blank" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://youtube.com/@nctu.edu.eg.1?si=du5LRh5Ud7oGWQV-" class="footer-social-link" target="_blank" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://www.tiktok.com/@newcairotechnological" class="footer-social-link" target="_blank" aria-label="TikTok">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <h6 class="footer-heading">{{ __('messages.navigation') }}</h6>
                <a href="{{ route('home') }}" class="footer-nav-link">{{ __('messages.home') }}</a>
                <a href="{{ route('about') }}" class="footer-nav-link">{{ __('messages.about') }}</a>
                <a href="{{ route('facultyit') }}" class="footer-nav-link">{{ __('messages.faculties') }}</a>
                <a href="{{ route('admission.create') }}" class="footer-nav-link">{{ __('messages.admissions') }}</a>
                <a href="{{ route('events') }}" class="footer-nav-link">{{ __('messages.events') }}</a>
                <a href="{{ route('contact') }}" class="footer-nav-link">{{ __('messages.contact') }}</a>
            </div>

            <div class="col-lg-4 col-md-6">
                <h6 class="footer-heading">{{ __('messages.quick_access') }}</h6>
                <a href="https://sis.nctu.edu.eg/Nctu/Registration/ED_Login.aspx" class="footer-nav-link" target="_blank">{{ __('messages.students_lms') }}</a>
                <a href="{{ route('login') }}" class="footer-nav-link">{{ __('messages.staff_lms') }}</a>
                <a href="{{ route('admission.create') }}" class="footer-nav-link">{{ __('messages.student_affairs') }}</a>
                <a href="{{ route('library') }}" class="footer-nav-link">{{ __('messages.library') }}</a>
                <a href="{{ route('trainings') }}" class="footer-nav-link">{{ __('messages.training') }}</a>
            </div>
        </div>

        <div class="footer-copyright">
            <p class="footer-copyright-text">&copy; 2025 {{ __('messages.footer_copyright') }}</p>
        </div>
    </div>
</footer>
