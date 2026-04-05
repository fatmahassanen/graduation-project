(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').css('top', '0px');
        } else {
            $('.sticky-top').css('top', '-100px');
        }
    });
    
    
    // Dropdown on mouse hover
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";
    
    $(window).on("load resize", function() {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
            function() {
                const $this = $(this);
                $this.addClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "true");
                $this.find($dropdownMenu).addClass(showClass);
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Header carousel
    $(".header-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>'
        ]
    });



    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        center: true,
        margin: 24,
        dots: true,
        loop: true,
        nav : false,
        responsive: {
            0:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });
    
})(jQuery);





function toggleAnswer(element) {
    let answer = element.nextElementSibling;

    // إغلاق جميع الإجابات الأخرى
    document.querySelectorAll('.answer').forEach(ans => {
        if (ans !== answer) ans.style.display = 'none';
    });

    // تبديل حالة الإجابة المختارة
    answer.style.display = (answer.style.display === 'block') ? 'none' : 'block';
}

// دا البراجراف اللى بعرف فيه مقدمة عن الجامعة
document.addEventListener("DOMContentLoaded", function () {
    let subtitle = document.querySelector(".subtitle");

    subtitle.addEventListener("mouseenter", function () {
        setTimeout(() => {
            subtitle.style.backgroundColor = "#00bcd4";
            subtitle.style.color = "white";
        }, 3000); // تأخير 3 ثوانٍ
    });

    subtitle.addEventListener("mouseleave", function () {
        subtitle.style.backgroundColor = "transparent";
        subtitle.style.color = "#333";
    });
});



document.getElementById("show-register").addEventListener("click", function() {
    document.getElementById("login-form").classList.add("hidden");
    document.getElementById("register-form").classList.remove("hidden");
});

document.getElementById("back-to-login").addEventListener("click", function() {
    document.getElementById("register-form").classList.add("hidden");
    document.getElementById("login-form").classList.remove("hidden");
});

document.getElementById("register-btn").addEventListener("click", function() {
    let fullname = document.getElementById("fullname").value;
    let email = document.getElementById("new-email").value;
    let password = document.getElementById("new-password").value;
    let confirmPassword = document.getElementById("confirm-password").value;
    
    if (!fullname || !email || !password || !confirmPassword) {
        alert("Please complete all fields before registering.");
        return;
    }
    if (password !== confirmPassword) {
        alert("Passwords do not match. Please try again.");
        return;
    }
    alert("Registration successful!");
});





